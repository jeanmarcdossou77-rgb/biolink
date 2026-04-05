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