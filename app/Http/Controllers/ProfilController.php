<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        return view('profil');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
        ]);

        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'age' => $request->age,
            'sexe' => $request->sexe,
            'poids' => $request->poids,
            'taille' => $request->taille,
            'etat_sante' => $request->etat_sante,
        ]);

        return redirect('/profil')->with('success', '✅ Profil mis à jour avec succès !');
    }
}