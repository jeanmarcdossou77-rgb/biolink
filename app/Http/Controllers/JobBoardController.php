<?php

namespace App\Http\Controllers;

use App\Models\JobBoard;
use Illuminate\Http\Request;

class JobBoardController extends Controller
{
    public function index()
    {
        $jobs = JobBoard::where('approuve', true)->latest()->paginate(12);
        $categories = ['Biologie', 'Phytothérapie', 'Médecine naturelle', 'Recherche', 'Pharmacie', 'Nutrition', 'Santé publique'];
        return view('jobs.index', compact('jobs', 'categories'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|min:5',
            'entreprise' => 'required',
            'lieu' => 'required',
            'description' => 'required|min:20',
            'competences' => 'required',
            'email_contact' => 'required|email',
        ]);

        JobBoard::create([
            'titre' => $request->titre,
            'entreprise' => $request->entreprise,
            'lieu' => $request->lieu,
            'type' => $request->type,
            'description' => $request->description,
            'competences' => $request->competences,
            'salaire' => $request->salaire,
            'email_contact' => $request->email_contact,
            'categorie' => $request->categorie,
            'approuve' => false,
        ]);

        return redirect('/jobs')->with('success', '✅ Votre offre a été soumise ! Elle sera publiée après validation.');
    }
}