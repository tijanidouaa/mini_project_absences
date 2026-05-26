<?php
namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\DemandePermission;
use App\Models\Enseignant;
use Illuminate\Http\Request;

class DemandePermissionController extends Controller
{
    // Afficher le formulaire
    public function index()
    {
        $enseignants = Enseignant::all();
        $demandes    = DemandePermission::where('etudiant_id', session('personne_id'))->get();
        return view('etudiant.demande_permission', compact('enseignants', 'demandes'));
    }

    // Envoyer une demande
    public function envoyer(Request $request)
    {
        $request->validate([
            'enseignant_id' => 'required',
            'message'       => 'required',
        ]);

        DemandePermission::create([
            'etudiant_id'   => session('personne_id'),
            'enseignant_id' => $request->enseignant_id,
            'message'       => $request->message,
            'etat'          => 'en_attente',
        ]);

        return back()->with('success', 'Demande envoyée.');
    }
}