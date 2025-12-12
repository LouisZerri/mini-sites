<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agent;

class AgentSeeder extends Seeder
{
    public function run(): void
    {
        $agents = [
            [
                'prenom' => 'Jean',
                'nom' => 'Dupont',
                'email' => 'jean.dupont@gestimmo.fr',
                'telephone' => '06 12 34 56 78',
                'bio' => 'Expert en immobilier depuis 15 ans, spécialisé dans les biens de prestige.',
                'secteur' => 'Paris 16ème',
                'reseaux_sociaux' => [
                    'linkedin' => 'https://linkedin.com/in/jeandupont',
                    'facebook' => 'https://facebook.com/jeandupont'
                ],
                'actif' => true,
            ],
            [
                'prenom' => 'Marie',
                'nom' => 'Martin',
                'email' => 'marie.martin@gestimmo.fr',
                'telephone' => '06 98 76 54 32',
                'bio' => 'Passionnée par l\'immobilier résidentiel et l\'accompagnement des primo-accédants.',
                'secteur' => 'Lyon et environs',
                'reseaux_sociaux' => [
                    'linkedin' => 'https://linkedin.com/in/mariemartin',
                ],
                'actif' => true,
            ],
            [
                'prenom' => 'Pierre',
                'nom' => 'Dubois',
                'email' => 'pierre.dubois@gestimmo.fr',
                'telephone' => '07 11 22 33 44',
                'bio' => 'Spécialiste de l\'investissement locatif et de la gestion de patrimoine immobilier.',
                'secteur' => 'Bordeaux',
                'reseaux_sociaux' => null,
                'actif' => true,
            ],
        ];

        foreach ($agents as $agentData) {
            Agent::create($agentData);
        }
    }
}