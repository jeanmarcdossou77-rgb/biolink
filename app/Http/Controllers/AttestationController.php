<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Remede;
use App\Models\Pathologie;
use Barryvdh\DomPDF\Facade\Pdf;

class AttestationController extends Controller
{
    public function download()
    {
        $user = Auth::user();

        // Récupérer les pathologies sur lesquelles l'utilisateur a publié
        $pathologiesPubliees = Remede::where('user_id', $user->id)
            ->where('approuve', true)
            ->with('pathologie')
            ->get()
            ->pluck('pathologie.nom')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $pdf = Pdf::loadView('attestation.pdf', compact('user', 'pathologiesPubliees'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'dpi' => 150,
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'margin_top' => 0,
                'margin_right' => 0,
                'margin_bottom' => 0,
                'margin_left' => 0,
            ]);

        $filename = 'Attestation_BioLink_' . str_replace(' ', '_', $user->name) . '_' . now()->format('Y') . '.pdf';

        return $pdf->download($filename);
    }

public function telecharger($id)
{
    $user = Auth::user();

    $pathologiesPubliees = Remede::where('user_id', $user->id)
        ->where('approuve', true)
        ->with('pathologie')
        ->get()
        ->pluck('pathologie.nom')
        ->filter()
        ->unique()
        ->values()
        ->toArray();

    $pdf = Pdf::loadView('attestation.pdf', compact('user', 'pathologiesPubliees'))
        ->setPaper('a4', 'portrait');

    $filename = 'Attestation_BioLink_' . str_replace(' ', '_', $user->name) . '_' . now()->format('Y') . '.pdf';

    return $pdf->download($filename);
}

}