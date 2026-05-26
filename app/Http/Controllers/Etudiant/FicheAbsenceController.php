<?php
namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;

class FicheAbsenceController extends Controller
{
    // Afficher les absences de l'étudiant connecté
    public function index()
    {
        $etudiant_id = session('personne_id');

        // Absences de l'année en cours
        $absences = Absence::where('etudiant_id', $etudiant_id)
                           ->where('annee_academique', '2025/2026')
                           ->with('element', 'enseignant')
                           ->get();

        // Absences des années passées
        $absences_passees = Absence::where('etudiant_id', $etudiant_id)
                                   ->where('annee_academique', '!=', '2025/2026')
                                   ->with('element')
                                   ->get();

        return view('etudiant.fiche_absence', compact('absences', 'absences_passees'));
    }
}