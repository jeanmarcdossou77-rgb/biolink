<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::withCount('members')->latest()->paginate(12);
        return view('social.groups', compact('groups'));
    }

    public function create()
    {
        if (!Auth::user()->peutCreerGroupe()) {
            return redirect()->back()->with('error',
                '❌ Vous devez être au moins Contributeur (6 publications validées) pour créer un groupe !'
            );
        }
        return view('social.create-group');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->peutCreerGroupe()) {
            return redirect()->back()->with('error',
                '❌ Grade insuffisant pour créer un groupe.'
            );
        }

        $request->validate([
            'nom' => 'required|min:3|max:100',
            'description' => 'required|min:10',
        ]);

        $group = Group::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'visibilite' => $request->visibilite ?? 'public',
            'categorie' => $request->categorie ?? 'Santé',
            'user_id' => Auth::id(),
            'membres_count' => 1,
        ]);

        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => Auth::id(),
            'role' => 'admin',
        ]);

        return redirect('/groups/' . $group->id)->with('success', '✅ Groupe créé !');
    }

    public function show($id)
    {
        $group = Group::with(['creator', 'members.user', 'posts.user'])->findOrFail($id);
        return view('social.group-show', compact('group'));
    }

    public function join($id)
    {
        $group = Group::findOrFail($id);
        if (!$group->isMember(Auth::id())) {
            GroupMember::create([
                'group_id' => $id,
                'user_id' => Auth::id(),
                'role' => 'membre',
            ]);
            $group->increment('membres_count');
        }
        return redirect()->back()->with('success', '✅ Vous avez rejoint le groupe !');
    }

    public function leave($id)
    {
        GroupMember::where('group_id', $id)
            ->where('user_id', Auth::id())
            ->delete();
        Group::findOrFail($id)->decrement('membres_count');
        return redirect()->back()->with('success', '👋 Vous avez quitté le groupe.');
    }

    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        if ($group->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }
        $group->delete();
        return redirect('/groups')->with('success', '🗑️ Groupe supprimé.');
    }
}