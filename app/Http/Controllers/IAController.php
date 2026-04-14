<?php

namespace App\Http\Controllers;

use App\Models\Pathologie;
use App\Models\Remede;
use Illuminate\Http\Request;

class IAController extends Controller
{
    public function index()
    {
        return view('ia.chat');
    }

    public function question(Request $request)
    {
        $question = strtolower(trim($request->question ?? ''));

        // Chercher dans la base de données
        $pathologies = Pathologie::where('nom', 'LIKE', "%{$question}%")
            ->orWhere('symptomes', 'LIKE', "%{$question}%")
            ->orWhere('description', 'LIKE', "%{$question}%")
            ->orWhere('categorie', 'LIKE', "%{$question}%")
            ->take(3)->get();

        $remedes = Remede::where('titre', 'LIKE', "%{$question}%")
            ->orWhere('description', 'LIKE', "%{$question}%")
            ->orWhere('ingredients', 'LIKE', "%{$question}%")
            ->where('approuve', true)
            ->take(3)->get();

        $reponse = '';

        if ($pathologies->count() > 0) {
            $p = $pathologies->first();
            $reponse = "🔬 <strong>{$p->nom}</strong><br><br>";

            if ($p->description) {
                $reponse .= "📋 <strong>Description :</strong> {$p->description}<br><br>";
            }
            if ($p->symptomes) {
                $reponse .= "🩺 <strong>Symptômes :</strong> {$p->symptomes}<br><br>";
            }
            if ($p->traitement_naturel) {
                $reponse .= "🌿 <strong>Traitement naturel :</strong> {$p->traitement_naturel}<br><br>";
            }
            if ($p->prevention) {
                $reponse .= "🛡️ <strong>Prévention :</strong> {$p->prevention}<br><br>";
            }

            // Remèdes associés
            $remedesAssocies = Remede::where('pathologie_id', $p->id)
                ->where('approuve', true)->take(2)->get();

            if ($remedesAssocies->count() > 0) {
                $reponse .= "💊 <strong>Remèdes naturels validés :</strong><br>";
                foreach ($remedesAssocies as $r) {
                    $reponse .= "• {$r->titre}<br>";
                }
                $reponse .= "<br>";
            }

            if ($pathologies->count() > 1) {
                $reponse .= "📌 <strong>Pathologies similaires :</strong> ";
                $reponse .= $pathologies->skip(1)->pluck('nom')->implode(', ');
                $reponse .= "<br><br>";
            }

            $reponse .= "🔗 <a href='/pathologies/{$p->id}' style='color:#00e5a0;'>Voir la fiche complète →</a>";

        } elseif ($remedes->count() > 0) {
            $r = $remedes->first();
            $reponse = "🌿 <strong>{$r->titre}</strong><br><br>";
            $reponse .= "📋 {$r->description}<br><br>";
            if ($r->ingredients) {
                $reponse .= "🧪 <strong>Ingrédients :</strong><br>{$r->ingredients}<br><br>";
            }
            if ($r->preparation) {
                $reponse .= "⚗️ <strong>Préparation :</strong><br>{$r->preparation}<br><br>";
            }
        } else {
            // Réponses prédéfinies intelligentes
            $reponses = [
                ['mots' => ['bonjour','salut','bonsoir','hello'], 'rep' => "Bonjour ! 😊 Je suis l'assistant IA de BioLink. Je peux vous aider à trouver des remèdes naturels pour plus de 300 pathologies. Posez-moi votre question !"],
                ['mots' => ['merci','thanks'], 'rep' => "Avec plaisir ! 🌿 N'hésitez pas si vous avez d'autres questions sur la santé naturelle."],
                ['mots' => ['fievre','temperature','chaud'], 'rep' => "🌡️ <strong>Contre la fièvre :</strong><br>• Décoction de feuilles de papaye<br>• Tisane de citronelle et gingembre<br>• Feuilles de neem bouillies<br>• Rester hydraté, repos<br><br>⚠️ Si la fièvre dépasse 39°C chez un enfant, consultez un médecin."],
                ['mots' => ['toux','rhume','grippe','nez'], 'rep' => "🤧 <strong>Contre la toux/rhume :</strong><br>• Jus de citron + miel + gingembre chaud<br>• Inhalation vapeur eucalyptus<br>• Tisane thym + miel<br>• Ail cru dans la nourriture<br><br>Consultez un médecin si symptômes persistent."],
                ['mots' => ['stress','anxiete','depression','nervo'], 'rep' => "🧘 <strong>Contre le stress :</strong><br>• Tisane valériane + passiflore<br>• Respiration profonde 4-7-8<br>• Tisane camomille le soir<br>• Activité physique régulière<br>• Méditation 10 min/jour"],
                ['mots' => ['douleur','mal','douleurs','arthrite'], 'rep' => "💊 <strong>Contre les douleurs :</strong><br>• Huile essentielle gaulthérie (massages)<br>• Curcuma + poivre noir (anti-inflammatoire)<br>• Gingembre frais en tisane<br>• Arnica en pommade (douleurs musculaires)"],
                ['mots' => ['constipation','digestion','ventre','estomac'], 'rep' => "🫃 <strong>Pour la digestion :</strong><br>• Boire 2L d'eau par jour<br>• Jus d'aloe vera le matin à jeun<br>• Tisane menthe poivrée après repas<br>• Graines de lin dans l'alimentation<br>• Papaye fraîche"],
                ['mots' => ['sommeil','insomnie','dormir'], 'rep' => "😴 <strong>Pour mieux dormir :</strong><br>• Tisane valériane 30 min avant coucher<br>• Éviter écrans 1h avant lit<br>• Respiration profonde<br>• Lavande en huile essentielle<br>• Tisane passiflore + mélisse"],
                ['mots' => ['grossesse','enceinte','bebe','naissance'], 'rep' => "🤰 Pour la grossesse, il est très important de consulter un professionnel de santé avant tout remède naturel. Certaines plantes sont contre-indiquées. Consultez toujours votre médecin."],
                ['mots' => ['aide','pouvoir','fonction','comment'], 'rep' => "🤖 Je peux vous aider avec :<br>• 🔬 Trouver une pathologie par son nom<br>• 🌿 Découvrir des remèdes naturels<br>• 🩺 Comprendre des symptômes<br>• 🛡️ Conseils de prévention<br><br>Exemple : tapez <em>diabète</em>, <em>paludisme</em>, <em>hypertension</em>..."],
            ];

            foreach ($reponses as $item) {
                foreach ($item['mots'] as $mot) {
                    if (str_contains($question, $mot)) {
                        $reponse = $item['rep'];
                        break 2;
                    }
                }
            }

            if (!$reponse) {
                $total = Pathologie::count();
                $reponse = "🔍 Je n'ai pas trouvé de résultat pour <strong>\"" . htmlspecialchars($request->question) . "\"</strong>.<br><br>";
                $reponse .= "💡 <strong>Suggestions :</strong><br>";
                $reponse .= "• Essayez le nom exact de la maladie (ex: <em>diabète</em>, <em>paludisme</em>)<br>";
                $reponse .= "• Décrivez un symptôme (ex: <em>fièvre</em>, <em>douleur tête</em>)<br>";
                $reponse .= "• Utilisez la <a href='/recherche' style='color:#00e5a0;'>recherche avancée →</a><br><br>";
                $reponse .= "📊 Notre base contient <strong>{$total} pathologies</strong> disponibles.";
            }
        }

        return response()->json(['reponse' => $reponse]);
    }
}