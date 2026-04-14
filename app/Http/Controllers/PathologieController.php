<?php

namespace App\Http\Controllers;

use App\Models\Pathologie;
use App\Models\Remede;
use Illuminate\Http\Request;

class PathologieController extends Controller
{
    public function show($id)
    {
    $pathologie = Pathologie::findOrFail($id);
    $pathologie->increment('vues');
    $remedes = Remede::where('pathologie_id', $id)->where('approuve', true)->get();
    return view('pathologie.show', compact('pathologie', 'remedes'));
    }

    public function index()
    {
        $pathologies = Pathologie::where('approuve', true)->latest()->paginate(12);
        return view('pathologie.index', compact('pathologies'));
    }
}