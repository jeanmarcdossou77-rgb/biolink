<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'images', 'comments.user'])
            ->where('visibilite', 'public')
            ->orWhere('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $users = User::where('id', '!=', Auth::id())->take(5)->get();

        return view('social.feed', compact('posts', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contenu' => 'required_without:images|nullable|string',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'contenu' => $request->contenu,
            'type' => 'statut',
            'visibilite' => $request->visibilite ?? 'public',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('posts', 'public');
                $post->images()->create([
                    'image_path' => $path,
                    'ordre' => $index,
                ]);
            }
        }

        return redirect()->back()->with('success', '✅ Publication créée !');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }
        $post->delete();
        return redirect()->back()->with('success', '🗑️ Publication supprimée !');
    }

    public function like($id)
    {
        $post = Post::findOrFail($id);
        $existing = Like::where('user_id', Auth::id())
            ->where('likeable_id', $id)
            ->where('likeable_type', Post::class)
            ->first();

        if ($existing) {
            $existing->delete();
            $post->decrement('likes_count');
            $liked = false;
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'likeable_id' => $id,
                'likeable_type' => Post::class,
            ]);
            $post->increment('likes_count');
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $post->fresh()->likes_count
        ]);
    }

    public function comment(Request $request, $id)
    {
        $request->validate(['contenu' => 'required|min:1']);

        $post = Post::findOrFail($id);
        $comment = Comment::create([
            'post_id' => $id,
            'user_id' => Auth::id(),
            'contenu' => $request->contenu,
        ]);
        $post->increment('comments_count');

        return response()->json([
            'comment' => [
                'id' => $comment->id,
                'contenu' => $comment->contenu,
                'user' => [
                    'name' => Auth::user()->name,
                    'photo' => Auth::user()->photo_profil,
                    'grade' => Auth::user()->nom_grade['emoji'],
                ],
                'created_at' => $comment->created_at->diffForHumans(),
            ],
            'count' => $post->fresh()->comments_count
        ]);
    }
}