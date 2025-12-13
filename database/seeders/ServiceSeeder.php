<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Agent;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $agents = Agent::all();

        foreach ($agents as $agent) {
            // Service 1
            Service::create([
                'agent_id' => $agent->id,
                'titre' => 'Sourcing & Négociation',
                'image' => null, // À ajouter via l'admin
                'description' => 'Accès à mon réseau Off-Market (Notaires, Marchands). Je négocie le prix pour gommer les frais de notaire dès l\'achat.',
                'points_forts' => [
                    'Rapport de visite détaillé',
                    'Estimation travaux immédiate',
                ],
                'ordre' => 1,
                'actif' => true,
            ]);

            // Service 2
            Service::create([
                'agent_id' => $agent->id,
                'titre' => 'Ingénierie Patrimoniale',
                'image' => null, // À ajouter via l'admin
                'description' => 'Ne laissez pas les impôts grignoter votre rendement. Simulation précise (LMNP Réel, SCI IS, Holding).',
                'points_forts' => [
                    'Simulation Cashflow Net Net',
                    'Mise en relation Expert-Comptable',
                ],
                'ordre' => 2,
                'actif' => true,
            ]);
        }
    }
}