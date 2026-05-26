<?php
namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\DemandePermission;
use App\Models\Notification;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class DemandePermissionController extends Controller
{
    // Afficher les demandes reçues
    public function index()
    {
        $enseignant_id = session('personne_id');
        $demandes = DemandePermission::where('enseignant_id', $enseignant_id)
                                     ->with('etudiant')
                                     ->get();
        return view('enseignant.demandes_permission', compact('demandes'));
    }

    // Répondre à une demande : OK ou Non
    public function repondre(Request $request, $id)
    {
        $demande = DemandePermission::findOrFail($id);
        $demande->reponse = $request->reponse; // OK ou Non
        $demande->etat    = 'traitee';
        $demande->save();

        // Envoyer une notification à l'étudiant
        $utilisateur = Utilisateur::where('personne_id', $demande->etudiant_id)
                                   ->where('role', 'etudiant')
                                   ->first();
        if ($utilisateur) {
            Notification::create([
                'utilisateur_id' => $utilisateur->id,
                'message'        => 'Votre demande de permission a reçu une réponse : ' . $request->reponse,
                'etat'           => 'non_lue',
            ]);
        }

        return back()->with('success', 'Réponse envoyée.');
    }
}