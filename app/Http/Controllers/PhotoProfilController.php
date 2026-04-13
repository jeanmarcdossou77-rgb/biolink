<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoProfilController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:5120|mimes:jpg,jpeg,png,gif,webp',
        ]);

        $user = Auth::user();

        if ($user->photo_profil) {
            Storage::disk('public')->delete($user->photo_profil);
        }

        $path = $request->file('photo')->store('photos_profil', 'public');
        $user->update(['photo_profil' => $path]);

        return redirect()->back()->with('success', '✅ Photo de profil mise à jour !');
    }

    public function delete()
    {
        $user = Auth::user();
        if ($user->photo_profil) {
            Storage::disk('public')->delete($user->photo_profil);
            $user->update(['photo_profil' => null]);
        }
        return redirect()->back()->with('success', '🗑️ Photo supprimée.');
    }
}