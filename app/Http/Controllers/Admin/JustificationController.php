<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Justification;
use App\Models\Absence;
use Illuminate\Http\Request;

class JustificationController extends Controller
{
    // Afficher toutes les justifications
    public function index()
    {
        $justifications = Justification::with('absence.etudiant')
                                       ->where('etat', 'en_attente')
                                       ->get();
        return view('admin.traiter_justification', compact('justifications'));
    }

    // Accepter ou refuser une justification
    public function traiter(Request $request, $id)
    {
        $justification       = Justification::findOrFail($id);
        $justification->etat = $request->etat; // acceptee ou refusee
        $justification->save();

        // Si acceptée, marquer l'absence comme justifiée
        if ($request->etat === 'acceptee') {
            $absence       = Absence::findOrFail($justification->absence_id);
            $absence->etat = 'justifiee';
            $absence->save();
        }

        return back()->with('success', 'Justification traitée.');
    }
}