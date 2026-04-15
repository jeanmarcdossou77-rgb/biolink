<?php

namespace App\Http\Controllers;

use App\Models\Pathologie;
use App\Models\Remede;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Pathologie::where('approuve', true);

        // Recherche textuelle
        if ($request->filled('query')) {
            $q = $request->input('query');
            $query->where(function($q2) use ($q) {
                $q2->where('nom', 'LIKE', "%{$q}%")
                   ->orWhere('description', 'LIKE', "%{$q}%")
                   ->orWhere('symptomes', 'LIKE', "%{$q}%")
                   ->orWhere('categorie', 'LIKE', "%{$q}%")
                   ->orWhere('cause', 'LIKE', "%{$q}%");
            });
        }

        // Filtre catégorie
        if ($request->filled('categorie') && $request->categorie !== 'autre') {
            $query->where('categorie', $request->categorie);
        }

        // Filtre gravité
        if ($request->filled('gravite')) {
            $query->where('gravite', $request->gravite);
        }

        // Filtre contagieux
        if ($request->filled('contagieux') && $request->contagieux !== '') {
            $query->where('contagieux', (bool)$request->contagieux);
        }

        $pathologies = $query->orderBy('nom')->paginate(12)->withQueryString();

        // Pathologies récentes pour affichage par défaut
        $recentes = Pathologie::where('approuve', true)
            ->latest()->take(6)->get();

        $categories = Pathologie::where('approuve', true)
            ->distinct()->orderBy('categorie')
            ->pluck('categorie');

        return view('search', compact('pathologies', 'recentes', 'categories'));
    }
}