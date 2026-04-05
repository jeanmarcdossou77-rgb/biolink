<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pathologie;

class IAController extends Controller
{
    public function index()
    {
        return view('ia.chat');
    }

    public function repondre(Request $request)
    {
        $message = strtolower($request->input('message'));

        // Recherche dans les pathologies
        $pathologies = Pathologie::where('approuve', true)
            ->where(function($q) use ($message) {
                $q->where('nom', 'like', '%'.$message.'%')
                  ->orWhere('symptomes', 'like', '%'.$message.'%')
                  ->orWhere('description', 'like', '%'.$message.'%');
            })
            ->take(3)
            ->get();

        if ($pathologies->count() > 0) {
            $reponse = "🔬 J'ai trouvé " . $pathologies->count() . " pathologie(s) correspondant à votre recherche :\n\n";
            foreach ($pathologies as $p) {
                $reponse .= "**" . $p->nom . "** (" . $p->categorie . ")\n";
                $reponse .= "📋 " . $p->description . "\n";
                if ($p->traitement_naturel) {
                    $reponse .= "🌿 Remède naturel : " . $p->traitement_naturel . "\n";
                }
                if ($p->prevention) {
                    $reponse .= "🛡️ Prévention : " . $p->prevention . "\n";
                }
                $reponse .= "\n";
            }
            $reponse .= "👉 Consultez toujours un médecin pour un diagnostic précis.";
        } else {
            // Réponses prédéfinies intelligentes
            $reponses = [
                'bonjour' => '👋 Bonjour ! Je suis l\'assistant IA de BioLink. Posez-moi vos questions sur les pathologies, symptômes ou remèdes naturels !',
                'merci' => '😊 Avec plaisir ! N\'hésitez pas si vous avez d\'autres questions sur votre santé.',
                'symptome' => '🩺 Décrivez-moi vos symptômes et je vais chercher les pathologies correspondantes dans notre base de données.',
                'remede' => '🌿 Dites-moi quelle pathologie vous concerne et je vous trouverai les remèdes naturels disponibles sur BioLink.',
                'aide' => '💡 Je peux vous aider à : \n1. Trouver une pathologie par nom ou symptôme\n2. Découvrir des remèdes naturels\n3. Vous informer sur les causes et prévention\n\nTapez simplement votre question !',
                'covid' => '🦠 Le COVID-19 est causé par le SARS-CoV-2. Remèdes naturels de soutien : Zinc, Vitamine C et D, Gingembre, Ail, Propolis. Consultez toujours un médecin !',
                'paludisme' => '🦟 Le paludisme est causé par Plasmodium transmis par moustiques. Remède traditionnel : Artemisia annua, feuilles de papaye. Protection : moustiquaires imprégnées !',
                'diabete' => '🩸 Le diabète de type 2 se gère avec : Cannelle, Fenugrec, Moringa, activité physique et alimentation équilibrée. Suivez votre médecin !',
                'tension' => '❤️ Pour l\'hypertension : Ail cru, Hibiscus, feuilles d\'olivier, réduction du sel, exercice régulier. Consultez votre médecin !',
            ];

            $reponse = null;
            foreach ($reponses as $mot => $rep) {
                if (str_contains($message, $mot)) {
                    $reponse = $rep;
                    break;
                }
            }

            if (!$reponse) {
                $reponse = "🤔 Je n'ai pas trouvé d'information précise sur \"" . $request->input('message') . "\" dans notre base de données.\n\n💡 Essayez de :\n- Taper le nom exact d'une pathologie\n- Décrire vos symptômes\n- Utiliser des mots simples comme 'diabète', 'migraine', 'fièvre'\n\n📚 Notre base contient " . Pathologie::where('approuve', true)->count() . " pathologies !";
            }
        }

        return response()->json(['reponse' => $reponse]);
    }
}