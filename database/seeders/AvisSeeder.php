<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Avis;
use App\Models\Agent;

class AvisSeeder extends Seeder
{
    public function run(): void
    {
        $agents = Agent::all();
        
        $commentaires = [
            "Excellent conseiller, très professionnel et à l'écoute !",
            "Très satisfait de l'accompagnement, je recommande vivement.",
            "Personne de confiance, m'a aidé à trouver le bien idéal.",
            "Service impeccable du début à la fin.",
            "Rapide, efficace et toujours disponible.",
        ];

        foreach ($agents as $agent) {
            // 5 avis par agent
            for ($i = 0; $i < 5; $i++) {
                Avis::create([
                    'agent_id' => $agent->id,
                    'nom_client' => fake()->firstName() . ' ' . fake()->lastName(),
                    'commentaire' => $commentaires[array_rand($commentaires)],
                    'note' => rand(4, 5),
                    'valide' => true,
                ]);
            }
        }
    }
}