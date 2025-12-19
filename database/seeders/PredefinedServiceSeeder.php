<?php

namespace Database\Seeders;

use App\Models\PredefinedService;
use Illuminate\Database\Seeder;

class PredefinedServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // MISE EN LOCATION
            ['name' => 'Estimation du loyer', 'description' => 'Analyse du marché local et fixation du loyer optimal', 'category' => 'location', 'sort_order' => 10],
            ['name' => 'Réalisation des états des lieux (entrée / sortie)', 'description' => 'États des lieux précis et détaillés, réalisés en toute impartialité, avec support numérique et report photographique', 'category' => 'location', 'sort_order' => 15],
            ['name' => 'Mise en location du bien', 'description' => 'Prise en charge complète de la mise en location : diffusion des annonces, organisation des visites, sélection des candidats', 'category' => 'location', 'sort_order' => 20],
            ['name' => 'Vérification des diagnostics', 'description' => 'Contrôle des DPE, électricité, gaz, ERP avant location', 'category' => 'location', 'sort_order' => 30],
            ['name' => 'Prise de photos du bien', 'description' => 'Réalisation de photos professionnelles pour l\'annonce', 'category' => 'location', 'sort_order' => 40],
            ['name' => 'Publication de l\'annonce', 'description' => 'Diffusion sur portails immobiliers et site de l\'agence', 'category' => 'location', 'sort_order' => 50],
            ['name' => 'Organisation des visites', 'description' => 'Planification et accompagnement des visites sur site', 'category' => 'location', 'sort_order' => 60],
            ['name' => 'Vérification de solvabilité', 'description' => 'Étude des justificatifs de revenus et garants', 'category' => 'location', 'sort_order' => 70],
            ['name' => 'Rédaction du bail conforme à la réglementation', 'description' => 'Rédaction d\'un bail conforme à la législation en vigueur (loi ALUR), adapté au type de location', 'category' => 'location', 'sort_order' => 80],

            // GESTION LOCATIVE
            ['name' => 'Gestion administrative locative', 'description' => 'Suivi des encaissements, émission des quittances, relances en cas d\'impayés et révision annuelle du loyer', 'category' => 'gestion', 'sort_order' => 100],
            ['name' => 'Relance pour impayé', 'description' => 'Envoi de rappels au locataire', 'category' => 'gestion', 'sort_order' => 110],
            ['name' => 'Régularisation des charges', 'description' => 'Calcul et refacturation annuelle des charges réelles', 'category' => 'gestion', 'sort_order' => 120],
            ['name' => 'Révision annuelle du loyer', 'description' => 'Application de l\'indice IRL', 'category' => 'gestion', 'sort_order' => 130],
            ['name' => 'Assistance fiscale et charges locatives', 'description' => 'Régularisation des charges, accompagnement à la déclaration fiscale (revenus fonciers, LMNP) et optimisation', 'category' => 'gestion', 'sort_order' => 140],

            // TRAVAUX & MAINTENANCE
            ['name' => 'Gestion de devis', 'description' => 'Demande et comparaison de devis auprès des prestataires', 'category' => 'travaux', 'sort_order' => 200],
            ['name' => 'Suivi d\'intervention', 'description' => 'Coordination et vérification des travaux', 'category' => 'travaux', 'sort_order' => 210],
            ['name' => 'Déclaration de sinistre', 'description' => 'Constitution du dossier auprès de l\'assurance', 'category' => 'travaux', 'sort_order' => 220],

            // AUTRES
            ['name' => 'Visite annuelle du logement', 'description' => 'Inspection et rapport d\'état général', 'category' => 'autres', 'sort_order' => 300],
            ['name' => 'Assistance juridique', 'description' => 'Conseil en cas de litige locatif', 'category' => 'autres', 'sort_order' => 310],
            ['name' => 'Assurance loyers impayés (GLI)', 'description' => 'Garantie Loyers Impayés', 'category' => 'autres', 'sort_order' => 320],
        ];

        foreach ($services as $service) {
            PredefinedService::create($service);
        }
    }
}