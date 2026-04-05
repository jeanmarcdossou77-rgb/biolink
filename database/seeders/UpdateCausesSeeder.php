<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pathologie;

class UpdateCausesSeeder extends Seeder
{
    public function run(): void
    {
        $updates = [
            'Diabète de type 2' => ['cause' => 'Sédentarité, obésité abdominale, alimentation riche en sucres raffinés, génétique, stress chronique', 'prevention' => 'Activité physique régulière, alimentation équilibrée, poids santé, réduction du stress', 'traitement_naturel' => 'Cannelle, fenugrec, bitter melon, feuilles de moringa, gymnema sylvestre, aloe vera', 'gravite' => 'modérée', 'contagieux' => 'non'],
            'Hypertension artérielle' => ['cause' => 'Excès de sel, sédentarité, obésité, stress, alcool, tabac, génétique, âge avancé', 'prevention' => 'Réduction du sel, activité physique, poids santé, arrêt tabac et alcool, gestion du stress', 'traitement_naturel' => 'Ail cru, hibiscus, olivier (feuilles), magnésium, potassium, oméga-3, respiration profonde', 'gravite' => 'modérée', 'contagieux' => 'non'],
            'Migraine' => ['cause' => 'Facteurs hormonaux, stress, manque de sommeil, certains aliments, lumières vives, génétique', 'prevention' => 'Gestion du stress, sommeil régulier, éviter déclencheurs alimentaires, hydratation', 'traitement_naturel' => 'Pétasite, grande camomille, magnésium, gingembre, lavande, menthe poivrée en application', 'gravite' => 'modérée', 'contagieux' => 'non'],
            'Insomnie' => ['cause' => 'Stress, anxiété, dépression, mauvaise hygiène de sommeil, caféine, écrans, douleurs chroniques', 'prevention' => 'Routine de sommeil fixe, éviter écrans le soir, chambre sombre et fraîche, relaxation', 'traitement_naturel' => 'Valériane, passiflore, mélisse, lavande, mélatonine naturelle, tisane de camomille', 'gravite' => 'légère', 'contagieux' => 'non'],
            'Arthrite' => ['cause' => 'Vieillissement, surpoids, traumatismes articulaires, infections, maladies auto-immunes, génétique', 'prevention' => 'Poids santé, activité physique adaptée, protection articulaire, alimentation anti-inflammatoire', 'traitement_naturel' => 'Curcuma, harpagophytum, boswellia, huile de poisson, gingembre, bains de sel d\'Epsom', 'gravite' => 'modérée', 'contagieux' => 'non'],
            'Anémie' => ['cause' => 'Carence en fer, vitamine B12 ou folates, maladies chroniques, parasitoses, hémorragies, génétique', 'prevention' => 'Alimentation riche en fer et vitamines B, traitement des parasitoses, supplémentation si besoin', 'traitement_naturel' => 'Moringa, épinards, betterave, spiruline, foie d\'animal, ortie, citron avec aliments ferreux', 'gravite' => 'modérée', 'contagieux' => 'non'],
            'Gastrite' => ['cause' => 'Helicobacter pylori, AINS, alcool, stress, alimentation épicée, tabac, reflux biliaire', 'prevention' => 'Éviter AINS prolongés, réduction alcool et tabac, alimentation douce, gestion du stress', 'traitement_naturel' => 'Aloe vera, réglisse déglycyrrhizinée, miel de Manuka, gingembre, camomille, curcuma', 'gravite' => 'légère', 'contagieux' => 'non'],
            'Eczéma' => ['cause' => 'Prédisposition génétique, allergènes, irritants cutanés, stress, déséquilibre du microbiome', 'prevention' => 'Hydratation cutanée, éviter irritants, identifier allergènes, gestion du stress', 'traitement_naturel' => 'Huile de coco, beurre de karité, avoine colloïdale, aloe vera, onagre, probiotiques', 'gravite' => 'légère', 'contagieux' => 'non'],
            'Asthme' => ['cause' => 'Allergènes, pollution, tabagisme passif, infections respiratoires, effort physique, génétique', 'prevention' => 'Éviter allergènes et pollution, arrêt tabac, exercice progressif, contrôle de l\'environnement', 'traitement_naturel' => 'Gingembre, curcuma, miel, eucalyptus, thym, boswellia, vitamine D, magnésium', 'gravite' => 'modérée', 'contagieux' => 'non'],
            'Dépression' => ['cause' => 'Déséquilibre neurochimique, traumatismes, stress chronique, génétique, maladies chroniques, isolement', 'prevention' => 'Activité physique, lien social, sommeil suffisant, gestion du stress, exposition à la lumière', 'traitement_naturel' => 'Millepertuis, safran, oméga-3, magnésium, luminothérapie, exercice physique, méditation', 'gravite' => 'modérée', 'contagieux' => 'non'],
            'COVID-19' => ['cause' => 'Virus SARS-CoV-2 transmis par gouttelettes respiratoires et aérosols en milieu confiné', 'prevention' => 'Vaccination, masque, distanciation sociale, ventilation des espaces, lavage des mains', 'traitement_naturel' => 'Zinc, vitamine C et D, gingembre, ail, miel noir, propolis, échinacée, repos absolu', 'gravite' => 'modérée', 'contagieux' => 'oui'],
            'Paludisme' => ['cause' => 'Parasite Plasmodium transmis par piqûre de moustique Anopheles femelle infectée la nuit', 'prevention' => 'Moustiquaires imprégnées, répulsifs, chimioprophylaxie, habits longs, eaux stagnantes éliminées', 'traitement_naturel' => 'Artemisia annua, feuilles de papaye, neem, quinquina, citronnelle, gingembre, ail', 'gravite' => 'grave', 'contagieux' => 'non'],
            'Tuberculose' => ['cause' => 'Mycobacterium tuberculosis transmis par voie aérienne lors de toux ou éternuements', 'prevention' => 'Vaccination BCG, dépistage précoce, ventilation des espaces, traitement complet des cas', 'traitement_naturel' => 'Ail, thym, curcuma, propolis, huile essentielle d\'eucalyptus, bonne nutrition, air frais', 'gravite' => 'grave', 'contagieux' => 'oui'],
            'Drépanocytose' => ['cause' => 'Mutation génétique du gène de l\'hémoglobine transmise par les deux parents porteurs du gène', 'prevention' => 'Conseil génétique avant mariage, dépistage néonatal, éviter déshydratation et infections', 'traitement_naturel' => 'Hydroxyurée naturelle, hydratation intense, feuilles de Cajanus cajan, magnésium, acide folique', 'gravite' => 'grave', 'contagieux' => 'non'],
            'Dengue' => ['cause' => 'Virus dengue transmis par moustique Aedes aegypti actif le jour en zones tropicales', 'prevention' => 'Élimination des eaux stagnantes, répulsifs, moustiquaires, habits couvrants, sprays', 'traitement_naturel' => 'Feuilles de papaye (augmentent plaquettes), gingembre, curcuma, hydratation intense, repos', 'gravite' => 'grave', 'contagieux' => 'non'],
            'Hépatite B' => ['cause' => 'Virus VHB transmis par sang contaminé, rapports sexuels non protégés, mère à enfant', 'prevention' => 'Vaccination hépatite B, rapports protégés, matériel médical stérile, dépistage femmes enceintes', 'traitement_naturel' => 'Chardon-Marie, artichaut, curcuma, réglisse, graines de sésame, éviter alcool totalement', 'gravite' => 'grave', 'contagieux' => 'oui'],
        ];

        foreach ($updates as $nom => $data) {
            Pathologie::where('nom', $nom)->update($data);
        }

        $this->command->info('✅ Causes mises à jour pour ' . count($updates) . ' pathologies !');
    }
}