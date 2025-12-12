<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Annonce;
use App\Models\Agent;

class AnnonceSeeder extends Seeder
{
    public function run(): void
    {
        $agents = Agent::all();

        foreach ($agents as $agent) {
            // 3 annonces par agent
            for ($i = 1; $i <= 3; $i++) {
                Annonce::create([
                    'agent_id' => $agent->id,
                    'titre' => "Magnifique appartement T{$i} - {$agent->secteur}",
                    'description' => "Superbe bien situé dans {$agent->secteur}, proche de toutes commodités. Rénové récemment avec des matériaux de qualité.",
                    'prix' => rand(150000, 800000),
                    'type' => $i % 2 == 0 ? 'location' : 'vente',
                    'photos' => null,
                    'visible' => true,
                ]);
            }
        }
    }
}