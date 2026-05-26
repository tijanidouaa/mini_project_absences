<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Etudiant;
use App\Models\Element;
use Illuminate\Http\Request;

class SaisieManuelleController extends Controller
{
    // Afficher le formulaire de saisie manuelle
    public function index()
    {
        $elements = Element::all();
        return view('admin.saisie_manuelle', compact('elements'));
    }

    // Étape 1 : vérifier les identifiants saisis
    public function verifier(Request $request)
    {
        $request->validate([
            'identifiants' => 'required',
            'element_id'   => 'required',
            'type_seance'  => 'required',
            'date_heure'   => 'required',
        ]);

        // Séparer les identifiants par virgule
        $liste = explode(',', $request->identifiants);
        $liste = array_map('trim', $liste);

        $etudiants_trouves  = [];
        $etudiants_inconnus = [];

        foreach ($liste as $massar) {
            $etudiant = Etudiant::where('massar', $massar)
                                ->whereNull('deleted_at')
                                ->first();
            if ($etudiant) {
                $etudiants_trouves[] = $etudiant;
            } else {
                $etudiants_inconnus[] = $massar;
            }
        }

        // Stocker en session pour validation définitive
        session([
            'saisie_manuelle' => [
                'etudiants'   => collect($etudiants_trouves)->pluck('id')->toArray(),
                'element_id'  => $request->element_id,
                'type_seance' => $request->type_seance,
                'date_heure'  => $request->date_heure,
            ]
        ]);

        return view('admin.saisie_manuelle', compact(
            'etudiants_trouves',
            'etudiants_inconnus'
        ))->with('elements', Element::all());
    }

    // Étape 2 : validation définitive
    public function valider()
    {
        $data          = session('saisie_manuelle');
        $enseignant_id = session('personne_id');

        foreach ($data['etudiants'] as $etudiant_id) {
            Absence::create([
                'etudiant_id'      => $etudiant_id,
                'element_id'       => $data['element_id'],
                'type_seance'      => $data['type_seance'],
                'date_heure'       => $data['date_heure'],
                'etat'             => 'non_justifiee',
                'enseignant_id'    => $enseignant_id,
                'annee_academique' => '2025/2026',
            ]);
        }

        session()->forget('saisie_manuelle');
        return redirect()->route('admin.absences')
                         ->with('success', 'Absences enregistrées.');
    }
}