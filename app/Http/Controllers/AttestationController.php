<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class AttestationController extends Controller
{
    public function telecharger($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() !== $user->id) {
            abort(403);
        }

        if ($user->grade_id < 3) {
            return redirect('/profil')->with('error', '❌ Vous devez atteindre le grade Chercheur Actif.');
        }

        $grades = [
            1 => ['nom' => 'Débutant', 'emoji' => '🌱'],
            2 => ['nom' => 'Contributeur', 'emoji' => '🌿'],
            3 => ['nom' => 'Chercheur Actif', 'emoji' => '🔬'],
            4 => ['nom' => 'Expert', 'emoji' => '⭐'],
            5 => ['nom' => 'Leader Scientifique', 'emoji' => '🏆'],
        ];

        $grade = $grades[$user->grade_id];
        $date = now()->format('d/m/Y');

        $pdf = Pdf::loadView('attestation.pdf', compact('user', 'grade', 'date'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Attestation_BioLink_' . str_replace(' ', '_', $user->name) . '.pdf');
    }
}