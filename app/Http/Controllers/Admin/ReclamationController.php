<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use Illuminate\Http\Request;

class ReclamationController extends Controller
{
    // Afficher toutes les réclamations
    public function index()
    {
        $reclamations = Reclamation::with('etudiant', 'absence')
                                   ->where('etat', 'en_attente')
                                   ->get();
        return view('admin.repondre_reclamation', compact('reclamations'));
    }

    // Répondre à une réclamation
    public function repondre(Request $request, $id)
    {
        $request->validate([
            'reponse' => 'required',
        ]);

        $reclamation          = Reclamation::findOrFail($id);
        $reclamation->reponse = $request->reponse;
        $reclamation->etat    = 'traitee';
        $reclamation->save();

        return back()->with('success', 'Réponse envoyée.');
    }
}