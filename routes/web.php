<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\SearchController;
use App\Http\Controllers\PathologieController;
use App\Http\Controllers\RemedeController;

Route::get('/recherche', [SearchController::class, 'index'])->name('search');
Route::get('/recherche/resultats', [SearchController::class, 'search'])->name('search.results');
Route::middleware('auth')->group(function () {
    Route::resource('pathologies', PathologieController::class);
    Route::resource('remedes', RemedeController::class);
});

Route::get('/pathologies/{id}', [PathologieController::class, 'show'])->name('pathologie.show');

Route::get('/remedes/create', [RemedeController::class, 'create'])->middleware('auth')->name('remede.create');
Route::post('/remedes', [RemedeController::class, 'store'])->middleware('auth')->name('remede.store');

use App\Http\Controllers\AdminController;

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/remedes/{id}/approuver', [AdminController::class, 'approuverRemede']);
    Route::delete('/remedes/{id}/rejeter', [AdminController::class, 'rejeterRemede']);
    Route::post('/pathologies/{id}/approuver', [AdminController::class, 'approuverPathologie']);
    Route::post('/users/{id}/make-admin', [AdminController::class, 'makeAdmin']);
    Route::post('/jobs/{id}/approuver', [AdminController::class, 'approuverJob']);
    Route::post('/users/{id}/remove-admin', [AdminController::class, 'removeAdmin']);
});

use App\Http\Controllers\ProfilController;

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
});

use App\Http\Controllers\IAController;

Route::get('/ia', [IAController::class, 'index'])->name('ia');
Route::post('/ia/repondre', [IAController::class, 'repondre'])->name('ia.repondre');

use App\Http\Controllers\JobBoardController;

Route::get('/jobs', [JobBoardController::class, 'index'])->name('jobs');
Route::get('/jobs/create', [JobBoardController::class, 'create'])->name('jobs.create');
Route::post('/jobs', [JobBoardController::class, 'store'])->name('jobs.store');

use App\Http\Controllers\AttestationController;

Route::middleware('auth')->get('/attestation/{id}', [AttestationController::class, 'telecharger'])->name('attestation');

use App\Http\Controllers\NotificationController;

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/count', [NotificationController::class, 'count']);
});

use App\Http\Controllers\PremiumController;

Route::get('/premium', [PremiumController::class, 'index'])->name('premium');
Route::post('/premium/activer', [PremiumController::class, 'activer'])->middleware('auth')->name('premium.activer');

use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\GroupController;

Route::middleware('auth')->group(function () {
    // Fil d'actualité
    Route::get('/feed', [PostController::class, 'index'])->name('feed');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{id}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{id}/comment', [PostController::class, 'comment'])->name('posts.comment');

    // Amis
    Route::post('/friends/request/{userId}', [FriendshipController::class, 'sendRequest'])->name('friends.request');
    Route::post('/friends/accept/{id}', [FriendshipController::class, 'accept'])->name('friends.accept');
    Route::post('/friends/reject/{id}', [FriendshipController::class, 'reject'])->name('friends.reject');
    Route::get('/friends/requests', [FriendshipController::class, 'requests'])->name('friends.requests');

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages');
    Route::get('/messages/{userId}', [MessageController::class, 'conversation'])->name('messages.conversation');
    Route::post('/messages/{userId}/send', [MessageController::class, 'send'])->name('messages.send');

    // Groupes
    Route::get('/groups', [GroupController::class, 'index'])->name('groups');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{id}', [GroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/{id}/join', [GroupController::class, 'join'])->name('groups.join');
    Route::post('/groups/{id}/leave', [GroupController::class, 'leave'])->name('groups.leave');

    // Admin messages
    Route::get('/admin/messages', [MessageController::class, 'adminView'])->name('admin.messages');
});

Route::get('/aide', function() { return view('aide'); })->name('aide');
Route::get('/feed', [App\Http\Controllers\PostController::class, 'index'])->middleware('auth')->name('feed');

Route::get('/sitemap.xml', function() {
    $pathologies = \App\Models\Pathologie::where('approuve', true)->get();
    $base = 'https://biolink-production-c2ce.up.railway.app';
    $content = '<?xml version="1.0" encoding="UTF-8"?>';
    $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $content .= '<url><loc>'.$base.'</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';
    $content .= '<url><loc>'.$base.'/recherche</loc><changefreq>daily</changefreq><priority>0.9</priority></url>';
    $content .= '<url><loc>'.$base.'/ia</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>';
    $content .= '<url><loc>'.$base.'/jobs</loc><changefreq>daily</changefreq><priority>0.8</priority></url>';
    $content .= '<url><loc>'.$base.'/premium</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>';
    $content .= '<url><loc>'.$base.'/aide</loc><changefreq>monthly</changefreq><priority>0.6</priority></url>';
    foreach ($pathologies as $p) {
        $content .= '<url><loc>'.$base.'/pathologies/'.$p->id.'</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>';
    }
    $content .= '</urlset>';
    return response($content)->header('Content-Type', 'text/xml');
});

Route::get('/privacy', function() { return view('privacy'); })->name('privacy');

use App\Http\Controllers\PhotoProfilController;

Route::middleware('auth')->group(function() {
    Route::post('/profil/photo', [PhotoProfilController::class, 'update'])->name('photo.update');
    Route::delete('/profil/photo', [PhotoProfilController::class, 'delete'])->name('photo.delete');
});

Route::post('/comments/{id}/like', function($id) {
    $comment = \App\Models\Comment::findOrFail($id);
    $existing = \App\Models\Like::where('user_id', auth()->id())
        ->where('likeable_id', $id)
        ->where('likeable_type', \App\Models\Comment::class)
        ->first();
    if ($existing) {
        $existing->delete();
        $comment->decrement('likes_count');
        $liked = false;
    } else {
        \App\Models\Like::create([
            'user_id' => auth()->id(),
            'likeable_id' => $id,
            'likeable_type' => \App\Models\Comment::class,
        ]);
        $comment->increment('likes_count');
        $liked = true;
    }
    return response()->json(['liked' => $liked, 'count' => $comment->fresh()->likes_count]);
})->middleware('auth');

Route::middleware('auth')->get('/api/notifications/count', function() {
    return response()->json([
        'messages' => \App\Models\Message::where('receiver_id', auth()->id())->where('lu', false)->count(),
        'notifications' => \App\Models\NotificationBiolink::where('user_id', auth()->id())->where('lu', false)->count(),
    ]);
});

Route::middleware('auth')->post('/signaler/{type}/{id}', function($type, $id) {
    $modelMap = ['post' => \App\Models\Post::class, 'comment' => \App\Models\Comment::class];
    if (!isset($modelMap[$type])) abort(404);

    \DB::table('signalements')->insert([
        'user_id' => auth()->id(),
        'signable_type' => $modelMap[$type],
        'signable_id' => $id,
        'raison' => request('raison', 'Contenu inapproprié'),
        'details' => request('details'),
        'statut' => 'en_attente',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    \App\Models\NotificationBiolink::envoyer(
        1,
        '🚨 Signalement reçu',
        auth()->user()->name . ' a signalé un contenu. Raison: ' . request('raison'),
        'alerte',
        '/admin'
    );

    return response()->json(['success' => true]);
})->name('signaler');

Route::post('/ia/question', [App\Http\Controllers\IAController::class, 'question'])->name('ia.question');

Route::middleware('auth')->group(function() {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
});