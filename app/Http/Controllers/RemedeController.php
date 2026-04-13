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
    ]);

    $pathologieId = null;

    if ($request->pathologie_id === 'autre' && $request->pathologie_libre) {
        // Créer automatiquement la nouvelle pathologie
        $nouvellePathologie = \App\Models\Pathologie::create([
            'nom' => $request->pathologie_libre,
            'categorie' => 'Autre',
            'description' => 'Pathologie ajoutée par la communauté BioLink.',
            'symptomes' => 'À compléter',
            'approuve' => false,
            'user_id' => Auth::id(),
        ]);
        $pathologieId = $nouvellePathologie->id;

        // Notifier l'admin
        \App\Models\NotificationBiolink::envoyer(
            1,
            '🆕 Nouvelle pathologie soumise',
            Auth::user()->name . ' a soumis la pathologie : ' . $request->pathologie_libre,
            'info',
            '/admin'
        );
    } else {
        $pathologieId = $request->pathologie_id;
    }

    Remede::create([
        'titre' => $request->titre,
        'description' => $request->description,
        'ingredients' => $request->ingredients,
        'preparation' => $request->preparation,
        'type' => $request->type ?? 'naturel',
        'sexe' => $request->sexe ?? 'tous',
        'age_min' => $request->age_min,
        'age_max' => $request->age_max,
        'pathologie_id' => $pathologieId,
        'user_id' => Auth::id(),
        'approuve' => false,
    ]);

    Auth::user()->increment('points', 10);
    Auth::user()->increment('publications_validees');

    return redirect('/dashboard')->with('success', '🌿 Votre remède a été soumis pour validation !');
}
}