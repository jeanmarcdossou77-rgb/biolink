<?php

namespace App\Http\Controllers;

use App\Models\Remede;
use App\Models\Pathologie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RemedeController extends Controller
{
    public function create()
    {
        $pathologies = Pathologie::where('approuve', true)->orderBy('nom')->get();
        return view('remede.create', compact('pathologies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|min:10',
            'description' => 'required|min:20',
            'ingredients' => 'required|min:10',
            'preparation' => 'required|min:20',
            'pathologie_id' => 'required|exists:pathologies,id',
        ]);

        Remede::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'ingredients' => $request->ingredients,
            'preparation' => $request->preparation,
            'type' => $request->type ?? 'naturel',
            'sexe' => $request->sexe ?? 'tous',
            'age_min' => $request->age_min,
            'age_max' => $request->age_max,
            'pathologie_id' => $request->pathologie_id,
            'user_id' => Auth::id(),
            'approuve' => false,
        ]);

        // Ajouter points à l'utilisateur
        Auth::user()->increment('points', 10);
        Auth::user()->increment('publications_validees');

        return redirect('/dashboard')->with('success', '🌿 Votre remède a été soumis ! Il sera validé très bientôt.');
    }
}