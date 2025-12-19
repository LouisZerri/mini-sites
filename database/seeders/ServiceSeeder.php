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
            Service::create([
                'agent_id' => $agent->id,
                'category' => 'location',
                'titre' => 'Réalisation des états des lieux (entrée / sortie)',
                'description' => 'États des lieux précis et détaillés, réalisés en toute impartialité, avec support numérique et report photographique.',
                'points_forts' => [
                    'Support numérique',
                    'Report photographique',
                ],
                'ordre' => 1,
                'actif' => true,
            ]);

            Service::create([
                'agent_id' => $agent->id,
                'category' => 'location',
                'titre' => 'Mise en location du bien',
                'description' => 'Prise en charge complète de la mise en location : diffusion des annonces, organisation des visites, sélection des candidats.',
                'points_forts' => [
                    'Diffusion multi-portails',
                    'Sélection rigoureuse des candidats',
                ],
                'ordre' => 2,
                'actif' => true,
            ]);

            Service::create([
                'agent_id' => $agent->id,
                'category' => 'gestion',
                'titre' => 'Gestion administrative locative',
                'description' => 'Suivi des encaissements, émission des quittances, relances en cas d\'impayés et révision annuelle du loyer.',
                'points_forts' => [
                    'Quittances automatiques',
                    'Suivi des paiements',
                ],
                'ordre' => 3,
                'actif' => true,
            ]);

            Service::create([
                'agent_id' => $agent->id,
                'category' => 'gestion',
                'titre' => 'Assistance fiscale et charges locatives',
                'description' => 'Régularisation des charges, accompagnement à la déclaration fiscale (revenus fonciers, LMNP) et optimisation.',
                'points_forts' => [
                    'Optimisation fiscale',
                    'Accompagnement personnalisé',
                ],
                'ordre' => 4,
                'actif' => true,
            ]);
        }
    }
}