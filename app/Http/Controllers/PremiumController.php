<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificationBiolink;

class PremiumController extends Controller
{
    public function index()
    {
        return view('premium.index');
    }

    public function activer(Request $request)
    {
        // Simulation activation Premium
        // En production : intégrer Stripe ou Mobile Money
        Auth::user()->update(['is_premium' => true]);

        NotificationBiolink::envoyer(
            Auth::id(),
            '🌟 Compte Premium activé !',
            'Félicitations ! Vous bénéficiez maintenant de toutes les fonctionnalités Premium de BioLink.',
            'success',
            '/dashboard'
        );

        return redirect('/dashboard')->with('success', '🌟 Bienvenue dans BioLink Premium !');
    }
}