<?php

namespace App\Http\Controllers;

use App\Helpers\CloudinaryHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoProfilController extends Controller
{
public function update(Request $request)
{
    $request->validate([
        'photo' => 'required|image|max:5120',
    ]);

    $user = Auth::user();

    $photoUrl = CloudinaryHelper::uploadImage(
        $request->file('photo')->getRealPath(),
        'biolink/profils'
    );

    if (!$photoUrl) {
        $path = $request->file('photo')->store('photos_profil', 'public');
        $photoUrl = asset('storage/' . $path);
    }

    $user->update(['photo_profil' => $photoUrl]);

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