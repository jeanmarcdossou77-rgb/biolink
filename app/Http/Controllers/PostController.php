<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Pathologie;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Helpers\CloudinaryHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
public function index()
{
    $posts = Post::with(['user', 'images', 'comments.user'])
        ->where(function($q) {
            $q->where('visibilite', 'public')
              ->orWhere('user_id', Auth::id());
        })
        ->latest()
        ->paginate(10);

    $users = User::where('id', '!=', Auth::id())
        ->orderBy('points', 'desc')
        ->take(6)
        ->get();

    $tendances = \App\Models\Pathologie::where('approuve', true)
        ->orderBy('vues', 'desc')
        ->take(5)
        ->get();

    return view('social.feed', compact('posts', 'users', 'tendances'));
}

public function store(Request $request)
{
    $request->validate([
        'contenu' => 'nullable|string|max:5000',
        'images.*' => 'nullable|image|max:5120',
        'video' => 'nullable|file|max:51200',
    ]);

    if (!$request->contenu && !$request->hasFile('images') && !$request->hasFile('video')) {
        return redirect()->back()->with('error', '❌ Ajoutez du texte, une photo ou une vidéo.');
    }

    $videoPath = null;
    if ($request->hasFile('video')) {
        $videoPath = $request->file('video')->store('videos', 'public');
        $videoUrl = \App\Helpers\CloudinaryHelper::uploadVideo(
            storage_path('app/public/' . $videoPath),
            'biolink/videos'
        );
        if ($videoUrl) {
            $videoPath = $videoUrl;
        } else {
            $videoPath = asset('storage/' . $videoPath);
        }
    }

    $post = Post::create([
        'user_id' => Auth::id(),
        'contenu' => $request->contenu ?? '',
        'type' => 'statut',
        'visibilite' => $request->visibilite ?? 'public',
        'video_path' => $videoPath,
        'group_id' => $request->group_id ?? null,
    ]);

    if ($request->hasFile('images')) {
        foreach (array_slice($request->file('images'), 0, 10) as $index => $image) {
            // Sauvegarder localement d'abord
            $localPath = $image->store('posts', 'public');
            $finalUrl = asset('storage/' . $localPath);

            // Essayer Cloudinary
            $cloudUrl = \App\Helpers\CloudinaryHelper::uploadImage(
                storage_path('app/public/' . $localPath),
                'biolink/posts'
            );

            if ($cloudUrl) {
                $finalUrl = $cloudUrl;
            }

            \App\Models\PostImage::create([
                'post_id' => $post->id,
                'image_path' => $finalUrl,
                'ordre' => $index,
            ]);
        }
    }

    Auth::user()->increment('points', 5);
    return redirect('/feed')->with('success', '✅ Publication créée !');
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