<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pathologie;
use App\Models\Remede;

class SearchController extends Controller
{
    public function index()
    {
        $categories = Pathologie::where('approuve', true)
            ->distinct()
            ->pluck('categorie');
            
        $pathologies = Pathologie::where('approuve', true)
            ->latest()
            ->take(6)
            ->get();

        return view('search', compact('categories', 'pathologies'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $categorie = $request->input('categorie');

        $pathologies = Pathologie::where('approuve', true)
            ->when($query, function($q) use ($query) {
                $q->where('nom', 'like', '%'.$query.'%')
                  ->orWhere('symptomes', 'like', '%'.$query.'%');
            })
            ->when($categorie, function($q) use ($categorie) {
                $q->where('categorie', $categorie);
            })
            ->get();

        return view('search', compact('pathologies', 'query', 'categorie'));
    }
}