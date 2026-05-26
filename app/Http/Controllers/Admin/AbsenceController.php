<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    // Afficher toutes les fiches d'absences
    public function index()
    {
        $absences = Absence::with('etudiant', 'element', 'enseignant')
                           ->orderBy('date_heure', 'desc')
                           ->get();
        return view('admin.fiches_absences', compact('absences'));
    }

    // Afficher le formulaire de modification
    public function modifier($id)
    {
        $absence = Absence::findOrFail($id);
        return view('admin.modifier_absence', compact('absence'));
    }

    // Enregistrer la modification
    public function update(Request $request, $id)
    {
        $absence = Absence::findOrFail($id);
        $absence->type_seance = $request->type_seance;
        $absence->date_heure  = $request->date_heure;
        $absence->etat        = $request->etat;
        $absence->save();
        return redirect()->route('admin.absences')
                         ->with('success', 'Absence modifiée.');
    }

    // Annuler une absence
    public function annuler($id)
    {
        $absence       = Absence::findOrFail($id);
        $absence->etat = 'annulee';
        $absence->save();
        return back()->with('success', 'Absence annulée.');
    }

    // Marquer comme justifiée
    public function justifier($id)
    {
        $absence       = Absence::findOrFail($id);
        $absence->etat = 'justifiee';
        $absence->save();
        return back()->with('success', 'Absence justifiée.');
    }
}