<?php
namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Justification;
use App\Models\Absence;
use Illuminate\Http\Request;

class JustificationController extends Controller
{
    // Afficher le formulaire de justification
    public function index()
    {
        $etudiant_id = session('personne_id');
        $absences = Absence::where('etudiant_id', $etudiant_id)
                           ->where('etat', 'non_justifiee')
                           ->get();
        return view('etudiant.justification', compact('absences'));
    }

    // Envoyer une justification avec fichier
    public function envoyer(Request $request)
    {
        $request->validate([
            'absence_id'   => 'required',
            'justificatif' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        // Stocker le fichier
        $nomFichier = $request->file('justificatif')
                              ->store('justificatifs', 'public');

        Justification::create([
            'absence_id' => $request->absence_id,
            'fichier'    => $nomFichier,
            'etat'       => 'en_attente',
        ]);

        return back()->with('success', 'Justification envoyée avec succès.');
    }
}