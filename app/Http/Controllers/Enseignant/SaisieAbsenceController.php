<?php
namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Etudiant;
use App\Models\Element;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SaisieAbsenceController extends Controller
{
    // Afficher le formulaire de saisie
    public function index()
    {
        $niveaux  = Niveau::all();
        $elements = Element::all();
        return view('enseignant.saisie_absence', compact('niveaux', 'elements'));
    }

    // Charger les étudiants de la classe choisie
    public function getEtudiants(Request $request)
    {
        $niveaux  = Niveau::all();
        $elements = Element::all();

        $etudiants = Etudiant::where('niveau_id', $request->niveau_id)
                             ->whereNull('deleted_at')
                             ->get();

        // Garder les valeurs du formulaire en session
        Session::put('saisie_type_seance', $request->type_seance);
        Session::put('saisie_element_id',  $request->element_id);
        Session::put('saisie_date_heure',  $request->date_heure);

        return view('enseignant.saisie_absence', compact(
            'niveaux', 'elements', 'etudiants'
        ));
    }

    // Valider et enregistrer les absences
    public function valider(Request $request)
    {
        $request->validate([
            'absents' => 'required|array',
        ]);

        $enseignant_id    = Session::get('personne_id');
        $annee_academique = '2025/2026';

        foreach ($request->absents as $etudiant_id) {
            Absence::create([
                'etudiant_id'      => $etudiant_id,
                'element_id'       => Session::get('saisie_element_id'),
                'type_seance'      => Session::get('saisie_type_seance'),
                'date_heure'       => Session::get('saisie_date_heure'),
                'etat'             => 'non_justifiee',
                'enseignant_id'    => $enseignant_id,
                'annee_academique' => $annee_academique,
            ]);
        }

        return redirect()->route('enseignant.saisie')
                         ->with('success', 'Absences enregistrées avec succès.');
    }
}