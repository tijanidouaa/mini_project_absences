<?php

namespace Database\Seeders;

use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\ModulePeda;
use App\Models\Niveau;
use App\Models\Element;
use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Configuration ──
        DB::table('configuration')->insertOrIgnore([
            ['cle' => 'seuil_annulation_absence',   'valeur' => '48',       'created_at' => now(), 'updated_at' => now()],
            ['cle' => 'seuil_avertissement_absences','valeur' => '3',        'created_at' => now(), 'updated_at' => now()],
            ['cle' => 'annee_academique_courante',   'valeur' => '2025/2026','created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Compte Admin ──
        Utilisateur::firstOrCreate(
            ['login' => 'admin'],
            [
                'password'    => Hash::make('Admin@1234'),
                'role'        => 'administrateur',
                'personne_id' => 0,
                'enabled'     => true,
            ]
        );

        // ── Enseignant exemple ──
        $ens = Enseignant::firstOrCreate(
            ['cin' => 'AB123456'],
            [
                'nom_fr'    => 'Benali',
                'prenom_fr' => 'Ahmed',
                'nom_ar'    => 'بنعلي',
                'prenom_ar' => 'أحمد',
                'email'     => 'ahmed.benali@ensah.ac.ma',
                'telephone' => '0612345678',
            ]
        );

        // ── Filière GI ──
        $filiere = Filiere::firstOrCreate(
            ['alias' => 'GI'],
            [
                'intitule'               => 'Génie Informatique',
                'annee_accreditation'    => 2022,
                'annee_fin_accreditation'=> 2027,
                'coordonnateur_id'       => $ens->id,
            ]
        );

        $n1 = Niveau::firstOrCreate(['filiere_id' => $filiere->id, 'libelle' => 'GI - 1ère Année S1']);
        $n2 = Niveau::firstOrCreate(['filiere_id' => $filiere->id, 'libelle' => 'GI - 1ère Année S2']);

        $m1 = ModulePeda::firstOrCreate(['code' => 'ASD101', 'niveau_id' => $n1->id], ['titre' => 'Algorithmique & Structures de Données']);
        $m2 = ModulePeda::firstOrCreate(['code' => 'PW101',  'niveau_id' => $n1->id], ['titre' => 'Programmation Web']);
        $m3 = ModulePeda::firstOrCreate(['code' => 'BD101',  'niveau_id' => $n2->id], ['titre' => 'Bases de Données']);

        Element::firstOrCreate(['titre' => 'Algorithmes',          'module_id' => $m1->id]);
        Element::firstOrCreate(['titre' => 'Structures de Données','module_id' => $m1->id]);
        Element::firstOrCreate(['titre' => 'HTML/CSS',             'module_id' => $m2->id]);
        Element::firstOrCreate(['titre' => 'JavaScript',           'module_id' => $m2->id]);
        Element::firstOrCreate(['titre' => 'PHP',                  'module_id' => $m2->id]);
        Element::firstOrCreate(['titre' => 'Modélisation',         'module_id' => $m3->id]);
        Element::firstOrCreate(['titre' => 'SQL',                  'module_id' => $m3->id]);

        // ── Étudiant exemple ──
        $etudiant = Etudiant::firstOrCreate(
            ['massar' => 'G123456789'],
            [
                'nom_fr'        => 'Nadir',
                'prenom_fr'     => 'Mohamed Anouar',
                'nom_ar'        => 'نادر',
                'prenom_ar'     => 'محمد أنور',
                'cin'           => 'CD987654',
                'email'         => 'mohamedanouar.nadir@etu.uae.ac.ma',
                'niveau_id'     => $n1->id,
                'cursus'        => 'Génie Informatique',
                'telephone'     => '0698765432',
                'date_naissance'=> '2005-03-15',
            ]
        );

        // Compte étudiant
        Utilisateur::firstOrCreate(
            ['login' => 'nadirmohamedanouar'],
            [
                'password'    => Hash::make('etudiant123'),
                'role'        => 'etudiant',
                'personne_id' => $etudiant->id,
                'enabled'     => true,
            ]
        );

        // Compte enseignant
        Utilisateur::firstOrCreate(
            ['login' => 'ahmedbenali'],
            [
                'password'    => Hash::make('enseignant123'),
                'role'        => 'enseignant',
                'personne_id' => $ens->id,
                'enabled'     => true,
            ]
        );

        $this->command->info('✅ Seeder terminé !');
        $this->command->info('👤 Admin : admin / Admin@1234');
        $this->command->info('👤 Enseignant : ahmedbenali / enseignant123');
        $this->command->info('👤 Étudiant : nadirmohamedanouar / etudiant123');
    }
}
