<?php
namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Configuration;
use Illuminate\Http\Request;

class AnnulationAbsenceController extends Controller
{
    // Afficher les absences récentes de l'enseignant
    public function index()
    {
        $enseignant_id = session('personne_id');
        $absences = Absence::where('enseignant_id', $enseignant_id)
                           ->with('etudiant', 'element')
                           ->orderBy('date_heure', 'desc')
                           ->get();
        return view('enseignant.annuler_absence', compact('absences'));
    }

    // Annuler une absence
    public function annuler($id)
    {
        $absence = Absence::findOrFail($id);

        // Récupérer le seuil depuis la configuration
        $seuil = Configuration::where('cle', 'seuil_annulation')
                               ->value('valeur');

        // Vérifier si l'absence est récente
        $diff = now()->diffInDays($absence->date_heure);

        if ($diff < $seuil) {
            $absence->etat = 'annulee';
            $absence->save();
            return back()->with('success', 'Absence annulée avec succès.');
        }

        return back()->withErrors(['erreur' => 'Annulation impossible : délai dépassé.']);
    }
}