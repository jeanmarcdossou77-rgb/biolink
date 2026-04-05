<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pathologie;
use App\Models\User;

class PathologieSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $pathologies = [
            [
                'nom' => 'Diabète de type 2',
                'categorie' => 'Endocrinologie',
                'description' => 'Maladie métabolique caractérisée par un excès de sucre dans le sang. Très répandue dans le monde entier.',
                'symptomes' => 'Soif excessive, fatigue, vision floue, mictions fréquentes, cicatrisation lente',
                'approuve' => true,
                'user_id' => $user->id,
            ],
            [
                'nom' => 'Hypertension artérielle',
                'categorie' => 'Cardiologie',
                'description' => 'Pression artérielle élevée de façon chronique. Facteur de risque majeur des maladies cardiovasculaires.',
                'symptomes' => 'Maux de tête, vertiges, saignements de nez, essoufflement, douleurs thoraciques',
                'approuve' => true,
                'user_id' => $user->id,
            ],
            [
                'nom' => 'Migraine',
                'categorie' => 'Neurologie',
                'description' => 'Céphalée intense et récurrente souvent accompagnée de nausées et de sensibilité à la lumière.',
                'symptomes' => 'Douleur pulsatile, nausées, vomissements, sensibilité à la lumière et au bruit',
                'approuve' => true,
                'user_id' => $user->id,
            ],
            [
                'nom' => 'Insomnie',
                'categorie' => 'Neurologie',
                'description' => 'Trouble du sommeil caractérisé par une difficulté à s\'endormir ou à maintenir le sommeil.',
                'symptomes' => 'Difficulté à s\'endormir, réveils nocturnes, fatigue diurne, irritabilité',
                'approuve' => true,
                'user_id' => $user->id,
            ],
            [
                'nom' => 'Arthrite',
                'categorie' => 'Rhumatologie',
                'description' => 'Inflammation des articulations causant douleur et raideur. Peut affecter une ou plusieurs articulations.',
                'symptomes' => 'Douleur articulaire, raideur, gonflement, rougeur, chaleur autour des articulations',
                'approuve' => true,
                'user_id' => $user->id,
            ],
            [
                'nom' => 'Anémie',
                'categorie' => 'Hématologie',
                'description' => 'Manque de globules rouges ou d\'hémoglobine dans le sang réduisant le transport d\'oxygène.',
                'symptomes' => 'Fatigue intense, pâleur, essoufflement, vertiges, palpitations cardiaques',
                'approuve' => true,
                'user_id' => $user->id,
            ],
            [
                'nom' => 'Gastrite',
                'categorie' => 'Gastroentérologie',
                'description' => 'Inflammation de la muqueuse de l\'estomac pouvant être aiguë ou chronique.',
                'symptomes' => 'Douleur abdominale, nausées, vomissements, ballonnements, perte d\'appétit',
                'approuve' => true,
                'user_id' => $user->id,
            ],
            [
                'nom' => 'Eczéma',
                'categorie' => 'Dermatologie',
                'description' => 'Maladie inflammatoire de la peau causant des démangeaisons et des rougeurs chroniques.',
                'symptomes' => 'Démangeaisons, rougeurs, peau sèche, éruptions cutanées, plaques squameuses',
                'approuve' => true,
                'user_id' => $user->id,
            ],
            [
                'nom' => 'Asthme',
                'categorie' => 'Pneumologie',
                'description' => 'Maladie inflammatoire chronique des voies respiratoires causant des difficultés à respirer.',
                'symptomes' => 'Essoufflement, sifflements respiratoires, toux nocturne, oppression thoracique',
                'approuve' => true,
                'user_id' => $user->id,
            ],
            [
                'nom' => 'Dépression',
                'categorie' => 'Psychiatrie',
                'description' => 'Trouble de l\'humeur caractérisé par une tristesse persistante et une perte d\'intérêt.',
                'symptomes' => 'Tristesse persistante, perte d\'intérêt, fatigue, troubles du sommeil, manque de concentration',
                'approuve' => true,
                'user_id' => $user->id,
            ],
        ];

        foreach ($pathologies as $pathologie) {
            Pathologie::create($pathologie);
        }
    }
}