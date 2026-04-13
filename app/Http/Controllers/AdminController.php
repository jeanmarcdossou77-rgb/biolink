<?php

namespace App\Http\Controllers;

use App\Models\Pathologie;
use App\Models\Remede;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Accès réservé à l\'administrateur.');
        }

        $stats = [
            'users' => User::count(),
            'pathologies' => Pathologie::count(),
            'remedes' => Remede::count(),
            'remedes_en_attente' => Remede::where('approuve', false)->count(),
            'pathologies_en_attente' => Pathologie::where('approuve', false)->count(),
        ];

        $remedes_en_attente = Remede::where('approuve', false)
            ->with(['user', 'pathologie'])
            ->latest()
            ->get();

        $pathologies_en_attente = Pathologie::where('approuve', false)
            ->with('user')
            ->latest()
            ->get();

        $derniers_users = User::latest()->take(10)->get();
$jobs_en_attente = \App\Models\JobBoard::where('approuve', false)->latest()->get();

return view('admin.index', compact('stats', 'remedes_en_attente', 'pathologies_en_attente', 'derniers_users', 'jobs_en_attente'));

        return view('admin.index', compact('stats', 'remedes_en_attente', 'pathologies_en_attente', 'derniers_users'));
    }

    public function approuverRemede($id)
    {
        if (!auth()->user()->is_admin) abort(403);
        $remede = Remede::findOrFail($id);
        $remede->update(['approuve' => true]);
        $remede->user->increment('points', 20);
        return redirect()->back()->with('success', '✅ Remède approuvé !');
    }

    public function rejeterRemede($id)
    {
        if (!auth()->user()->is_admin) abort(403);
        Remede::findOrFail($id)->delete();
        return redirect()->back()->with('success', '❌ Remède rejeté.');
    }

    public function approuverPathologie($id)
    {
        if (!auth()->user()->is_admin) abort(403);
        Pathologie::findOrFail($id)->update(['approuve' => true]);
        return redirect()->back()->with('success', '✅ Pathologie approuvée !');
    }

public function makeAdmin($id)
{
    // Seul le super admin (ID 1 = Jean-Marc) peut promouvoir
    if (Auth::id() !== 1) {
        abort(403, 'Seul le fondateur de BioLink peut attribuer les droits admin.');
    }
    User::findOrFail($id)->update(['is_admin' => true]);
    return redirect()->back()->with('success', '✅ Administrateur promu !');
}

public function removeAdmin($id)
{
    if (Auth::id() !== 1) {
        abort(403);
    }
    if ($id == 1) {
        return redirect()->back()->with('error', '❌ Impossible de retirer vos propres droits !');
    }
    User::findOrFail($id)->update(['is_admin' => false]);
    return redirect()->back()->with('success', '✅ Droits admin retirés.');
}

    public function approuverJob($id)
{
    if (!auth()->user()->is_admin) abort(403);
    \App\Models\JobBoard::findOrFail($id)->update(['approuve' => true]);
    return redirect()->back()->with('success', '✅ Offre d\'emploi approuvée !');
}
}