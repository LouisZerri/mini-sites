<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agent;

class AgentSeeder extends Seeder
{
    public function run(): void
    {
        Agent::create([
            'prenom' => 'Jean',
            'nom' => 'Dupont',
            'titre' => 'Expert en Investissement Locatif',
            'email' => 'jean.dupont@gestimmo.fr',
            'telephone' => '06 12 34 56 78',
            'secteur' => 'Paris',
            'langues' => 'FR / EN',
            'bio' => 'Passionné par l\'immobilier depuis 10 ans, je vous accompagne dans vos projets d\'investissement.',
            'accroche' => 'Spécialiste de l\'immobilier locatif à haut rendement. J\'accompagne les investisseurs pour bâtir un patrimoine rentable et sécurisé.',
            'info_legale' => 'Agent commercial - 123 456 789 RSAC Paris',
            'parcours' => 'Ancien gestionnaire de patrimoine, j\'ai quitté le monde bancaire pour aller sur le terrain. L\'immobilier reste le roi des placements, à condition de maîtriser les 3 piliers : L\'Achat, Les Travaux et la Fiscalité.',
            'actif' => true,
            'disponible' => true,
            'reseaux_sociaux' => [
                'linkedin' => 'https://linkedin.com/in/jeandupont',
                'facebook' => 'https://facebook.com/jeandupont',
            ],
        ]);

        Agent::create([
            'prenom' => 'Marie',
            'nom' => 'Martin',
            'titre' => 'Spécialiste Transaction',
            'email' => 'marie.martin@gestimmo.fr',
            'telephone' => '06 23 45 67 89',
            'secteur' => 'Lyon',
            'langues' => 'FR / EN / ES',
            'bio' => 'Experte en transaction immobilière, je vous aide à vendre ou acheter votre bien au meilleur prix.',
            'accroche' => 'Experte de la transaction immobilière avec une approche humaine et professionnelle.',
            'info_legale' => 'Agent commercial - 987 654 321 RSAC Lyon',
            'parcours' => 'Plus de 15 ans d\'expérience dans l\'immobilier résidentiel. Mon objectif : votre satisfaction.',
            'actif' => true,
            'disponible' => true,
            'reseaux_sociaux' => [
                'linkedin' => 'https://linkedin.com/in/mariemartin',
                'instagram' => 'https://instagram.com/mariemartin',
            ],
        ]);

        Agent::create([
            'prenom' => 'Pierre',
            'nom' => 'Dubois',
            'titre' => 'Conseiller Gestion Locative',
            'email' => 'pierre.dubois@gestimmo.fr',
            'telephone' => '06 34 56 78 90',
            'secteur' => 'Bordeaux',
            'langues' => 'FR',
            'bio' => 'Gestionnaire de patrimoine spécialisé dans la gestion locative.',
            'accroche' => 'Confiez-moi la gestion de votre patrimoine locatif en toute sérénité.',
            'info_legale' => 'Agent commercial - 456 789 123 RSAC Bordeaux',
            'parcours' => 'Expert en gestion locative, j\'optimise vos revenus fonciers et gère vos locataires.',
            'actif' => true,
            'disponible' => true,
            'reseaux_sociaux' => [
                'linkedin' => 'https://linkedin.com/in/pierredubois',
            ],
        ]);
    }
}