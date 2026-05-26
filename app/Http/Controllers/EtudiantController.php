<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\HistoriqueModification;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtudiantController extends Controller
{
    // ──────────────────────────────────────────────
    // Liste + Recherche
    // ──────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Etudiant::with('niveau.filiere');

        // Recherche normale
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nom_fr',    'LIKE', "%$search%")
                  ->orWhere('prenom_fr','LIKE', "%$search%")
                  ->orWhere('massar',   'LIKE', "%$search%")
                  ->orWhere('cin',      'LIKE', "%$search%");
            });
        }

        // Filtre niveau
        if ($niveauId = $request->input('niveau_id')) {
            $query->where('niveau_id', $niveauId);
        }

        $etudiants = $query->orderBy('nom_fr')->paginate(20)->withQueryString();
        $niveaux   = Niveau::with('filiere')->get();

        return view('etudiants.index', compact('etudiants', 'niveaux'));
    }

    // Corbeille (soft-deleted)
    public function trashed()
    {
        $etudiants = Etudiant::onlyTrashed()->with('niveau')->paginate(20);
        return view('etudiants.trashed', compact('etudiants'));
    }

    // ──────────────────────────────────────────────
    // Create
    // ──────────────────────────────────────────────
    public function create()
    {
        $niveaux = Niveau::with('filiere')->get();
        return view('etudiants.create', compact('niveaux'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_fr'         => 'required|string|max:100',
            'prenom_fr'      => 'required|string|max:100',
            'nom_ar'         => 'nullable|string|max:100',
            'prenom_ar'      => 'nullable|string|max:100',
            'massar'         => 'required|string|max:20|unique:etudiants,massar',
            'cin'            => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:100',
            'niveau_id'      => 'nullable|exists:niveaux,id',
            'cursus'         => 'nullable|string|max:100',
            'telephone'      => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
        ]);

        Etudiant::create($data);
        return redirect()->route('etudiants.index')->with('success', 'Étudiant ajouté avec succès.');
    }

    // ──────────────────────────────────────────────
    // Edit
    // ──────────────────────────────────────────────
    public function edit(Etudiant $etudiant)
    {
        $niveaux = Niveau::with('filiere')->get();
        return view('etudiants.edit', compact('etudiant', 'niveaux'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        $data = $request->validate([
            'nom_fr'         => 'required|string|max:100',
            'prenom_fr'      => 'required|string|max:100',
            'nom_ar'         => 'nullable|string|max:100',
            'prenom_ar'      => 'nullable|string|max:100',
            'massar'         => 'required|string|max:20|unique:etudiants,massar,'.$etudiant->id,
            'cin'            => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:100',
            'niveau_id'      => 'nullable|exists:niveaux,id',
            'cursus'         => 'nullable|string|max:100',
            'telephone'      => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
        ]);

        // Tracer les modifications champ par champ
        $trackedFields = ['nom_fr','prenom_fr','email','telephone','niveau_id','cin','massar','cursus'];
        foreach ($trackedFields as $field) {
            if (array_key_exists($field, $data) && (string)$etudiant->$field !== (string)$data[$field]) {
                HistoriqueModification::create([
                    'etudiant_id'    => $etudiant->id,
                    'utilisateur_id' => Auth::id(),
                    'champ_modifie'  => $field,
                    'ancienne_valeur'=> $etudiant->$field,
                    'nouvelle_valeur'=> $data[$field],
                ]);
            }
        }

        $etudiant->update($data);
        return redirect()->route('etudiants.index')->with('success', 'Étudiant modifié avec succès.');
    }

    // ──────────────────────────────────────────────
    // Soft Delete / Restore
    // ──────────────────────────────────────────────
    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete(); // soft delete
        return redirect()->route('etudiants.index')->with('success', 'Étudiant supprimé (récupérable depuis la corbeille).');
    }

    public function restore($id)
    {
        Etudiant::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('etudiants.trashed')->with('success', 'Étudiant restauré.');
    }

    // ──────────────────────────────────────────────
    // Historique modifications
    // ──────────────────────────────────────────────
    public function historique(Etudiant $etudiant)
    {
        $historique = $etudiant->historique()->with('utilisateur')->latest()->paginate(20);
        return view('etudiants.historique', compact('etudiant', 'historique'));
    }

    // ──────────────────────────────────────────────
    // Export CSV
    // ──────────────────────────────────────────────
    public function exportCsv(Request $request)
    {
        $query = Etudiant::with('niveau.filiere');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nom_fr', 'LIKE', "%$search%")
                  ->orWhere('prenom_fr', 'LIKE', "%$search%");
            });
        }
        if ($niveauId = $request->input('niveau_id')) {
            $query->where('niveau_id', $niveauId);
        }

        $etudiants = $query->orderBy('nom_fr')->get();

        $filename = 'etudiants_' . now()->format('Y-m-d') . '.csv';
        $headers  = ['Content-Type' => 'text/csv; charset=UTF-8', 'Content-Disposition' => "attachment; filename=$filename"];

        $callback = function () use ($etudiants) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM for Excel
            fputcsv($file, ['Nom','Prénom','Massar','CIN','Email','Téléphone','Date Naissance','Niveau','Filière']);
            foreach ($etudiants as $e) {
                fputcsv($file, [
                    $e->nom_fr, $e->prenom_fr, $e->massar, $e->cin,
                    $e->email, $e->telephone,
                    $e->date_naissance?->format('d/m/Y'),
                    $e->niveau?->libelle,
                    $e->niveau?->filiere?->alias,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
