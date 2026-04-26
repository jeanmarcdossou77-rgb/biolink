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
        'images.*' => 'nullable|image|max:20480',
        'video' => 'nullable|file|max:102400',
    ]);

    if (!$request->contenu && !$request->hasFile('images') && !$request->hasFile('video')) {
        return redirect()->back()->with('error', '❌ Ajoutez du texte, une photo ou une vidéo.');
    }

    $videoPath = null;
    if ($request->hasFile('video')) {
        $localVideo = $request->file('video')->store('videos', 'public');
        $cloudUrl = \App\Helpers\CloudinaryHelper::uploadVideo(
            storage_path('app/public/' . $localVideo)
        );
        $videoPath = $cloudUrl ?? asset('storage/' . $localVideo);
    }

    // Lien vidéo externe (YouTube, TikTok)
if ($request->video_url && !$videoPath) {
    $videoPath = $request->video_url;
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
            try {
                // Compresser avant upload
                $compressedPath = $this->compressImage($image);
                
                $cloudUrl = \App\Helpers\CloudinaryHelper::uploadImage(
                    $compressedPath, 'biolink/posts'
                );

                $finalUrl = $cloudUrl ?? asset('storage/' . $image->store('posts', 'public'));

                \App\Models\PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => $finalUrl,
                    'ordre' => $index,
                ]);

                // Supprimer le fichier compressé temporaire
                if (file_exists($compressedPath)) {
                    @unlink($compressedPath);
                }

            } catch (\Exception $e) {
                \Log::error('Upload image error: ' . $e->getMessage());
                $path = $image->store('posts', 'public');
                \App\Models\PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => asset('storage/' . $path),
                    'ordre' => $index,
                ]);
            }
        }
    }

    Auth::user()->increment('points', 5);
    return redirect('/feed')->with('success', '✅ Publication créée !');
}

private function compressImage($image)
{
    $tmpPath = sys_get_temp_dir() . '/' . uniqid('biolink_', true) . '.jpg';
    $mime = $image->getMimeType();
    $srcPath = $image->getRealPath();

    try {
        $src = null;
        if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
            $src = @imagecreatefromjpeg($srcPath);
        } elseif ($mime === 'image/png') {
            $src = @imagecreatefrompng($srcPath);
        } elseif ($mime === 'image/gif') {
            $src = @imagecreatefromgif($srcPath);
        } elseif ($mime === 'image/webp') {
            $src = @imagecreatefromwebp($srcPath);
        } elseif ($mime === 'image/bmp') {
            $src = @imagecreatefrombmp($srcPath);
        }

        if (!$src) {
            return $srcPath;
        }

        $origW = imagesx($src);
        $origH = imagesy($src);
        $maxSize = 1200;

        if ($origW > $maxSize || $origH > $maxSize) {
            $ratio = min($maxSize / $origW, $maxSize / $origH);
            $newW = intval($origW * $ratio);
            $newH = intval($origH * $ratio);
        } else {
            $newW = $origW;
            $newH = $origH;
        }

        $dst = imagecreatetruecolor($newW, $newH);
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefilledrectangle($dst, 0, 0, $newW, $newH, $white);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
        imagedestroy($src);
        imagejpeg($dst, $tmpPath, 85);
        imagedestroy($dst);

        return $tmpPath;

    } catch (\Exception $e) {
        return $srcPath;
    }
}

    // Redimensionner si trop grande
    $origH = imagesy($src);
    $maxW = 1200;
    $maxH = 1200;

    if ($origW > $maxW || $origH > $maxH) {
        $ratio = min($maxW / $origW, $maxH / $origH);
        $newW = intval($origW * $ratio);
        $newH = intval($origH * $ratio);
        $dst = imagecreatetruecolor($newW, $newH);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
        imagedestroy($src);
        $src = $dst;
    }

    // Sauvegarder en JPEG compressé (qualité 80%)
    imagejpeg($src, $tmpPath, 80);
    imagedestroy($src);

    return $tmpPath;
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