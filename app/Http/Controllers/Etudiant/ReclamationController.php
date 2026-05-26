<?php
namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use App\Models\Absence;
use Illuminate\Http\Request;

class ReclamationController extends Controller
{
    // Afficher le formulaire de réclamation
    public function index()
    {
        $etudiant_id = session('personne_id');
        $absences    = Absence::where('etudiant_id', $etudiant_id)->get();
        $reclamations = Reclamation::where('etudiant_id', $etudiant_id)->get();
        return view('etudiant.reclamation', compact('absences', 'reclamations'));
    }

    // Envoyer une réclamation
    public function envoyer(Request $request)
    {
        $request->validate([
            'absence_id' => 'required',
            'message'    => 'required',
        ]);

        Reclamation::create([
            'absence_id'  => $request->absence_id,
            'etudiant_id' => session('personne_id'),
            'message'     => $request->message,
            'etat'        => 'en_attente',
        ]);

        return back()->with('success', 'Réclamation envoyée.');
    }
}