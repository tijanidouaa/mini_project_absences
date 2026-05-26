<?php
namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Absence;
use Illuminate\Http\Request;

class FicheEtudiantController extends Controller
{
    // Chercher un étudiant par identifiant
    public function index()
    {
        return view('enseignant.fiche_etudiant');
    }

    public function chercher(Request $request)
    {
        $etudiant = Etudiant::where('massar', $request->identifiant)
                            ->whereNull('deleted_at')
                            ->first();

        if (!$etudiant) {
            return back()->withErrors([
                'erreur' => 'Identifiant ne correspond à aucun étudiant.'
            ]);
        }

        $absences = Absence::where('etudiant_id', $etudiant->id)
                           ->where('annee_academique', '2025/2026')
                           ->with('element')
                           ->get();

        return view('enseignant.fiche_etudiant', compact('etudiant', 'absences'));
    }
}