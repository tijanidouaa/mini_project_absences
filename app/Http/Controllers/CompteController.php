<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\LogAction;
use App\Models\LogConnexion;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompteController extends Controller
{
    public function index()
    {
        $comptes = Utilisateur::orderByDesc('id')->paginate(20);
        return view('comptes.index', compact('comptes'));
    }

    // ──────────────────────────────────────────────
    // Recherche personne (AJAX)
    // ──────────────────────────────────────────────
    public function searchPerson(Request $request)
    {
        $role  = $request->input('role');
        $query = $request->input('q');

        if ($role === 'etudiant') {
            $person = Etudiant::where('massar', $query)->whereNull('deleted_at')->first();
        } else {
            $person = Enseignant::where('cin', $query)->first();
        }

        if (!$person) {
            return response()->json(['error' => 'Aucune personne trouvée avec cet identifiant.'], 404);
        }

        return response()->json($person);
    }

    // ──────────────────────────────────────────────
    // Créer un compte
    // ──────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'role'        => 'required|in:etudiant,enseignant',
            'personne_id' => 'required|integer',
        ]);

        // Récupérer la personne
        $person = $request->role === 'etudiant'
            ? Etudiant::findOrFail($request->personne_id)
            : Enseignant::findOrFail($request->personne_id);

        // Générer login unique : prénom+nom sans espaces/accents
        $base  = strtolower($this->removeAccents($person->prenom_fr . $person->nom_fr));
        $base  = preg_replace('/[^a-z0-9]/', '', $base);
        $login = $base;
        $i     = 1;
        while (Utilisateur::where('login', $login)->exists()) {
            $login = $base . $i++;
        }

        // Mot de passe aléatoire
        $plainPassword = Str::random(10);

        $compte = Utilisateur::create([
            'login'       => $login,
            'password'    => Hash::make($plainPassword),
            'role'        => $request->role,
            'personne_id' => $request->personne_id,
        ]);

        return redirect()->route('comptes.index')
            ->with('success', "Compte créé ! Login : <strong>$login</strong> — Mot de passe : <strong>$plainPassword</strong>");
    }

    // ──────────────────────────────────────────────
    // Activer / Désactiver
    // ──────────────────────────────────────────────
    public function toggleEnabled(Utilisateur $compte)
    {
        $compte->update(['enabled' => !$compte->enabled]);
        $status = $compte->enabled ? 'activé' : 'désactivé';
        return back()->with('success', "Compte $status.");
    }

    // ──────────────────────────────────────────────
    // Verrouiller / Déverrouiller
    // ──────────────────────────────────────────────
    public function toggleLocked(Utilisateur $compte)
    {
        $compte->update(['locked' => !$compte->locked, 'tentatives' => 0]);
        $status = $compte->locked ? 'verrouillé' : 'déverrouillé';
        return back()->with('success', "Compte $status.");
    }

    // ──────────────────────────────────────────────
    // Réinitialiser mot de passe
    // ──────────────────────────────────────────────
    public function resetPassword(Utilisateur $compte)
    {
        $plain = Str::random(10);
        $compte->update(['password' => Hash::make($plain), 'tentatives' => 0, 'locked' => false]);
        return back()->with('success', "Nouveau mot de passe : <strong>$plain</strong>");
    }

    // ──────────────────────────────────────────────
    // Changer le rôle
    // ──────────────────────────────────────────────
    public function changeRole(Request $request, Utilisateur $compte)
    {
        $request->validate(['role' => 'required|in:etudiant,enseignant,administrateur']);
        $compte->update(['role' => $request->role]);
        return back()->with('success', 'Rôle mis à jour.');
    }

    // ──────────────────────────────────────────────
    // Logs d'un utilisateur
    // ──────────────────────────────────────────────
    public function logs(Utilisateur $compte)
    {
        $connexions = LogConnexion::where('utilisateur_id', $compte->id)->latest()->paginate(30, ['*'], 'conn');
        $actions    = LogAction::where('utilisateur_id', $compte->id)->latest()->paginate(50, ['*'], 'act');
        return view('comptes.logs', compact('compte', 'connexions', 'actions'));
    }

    // Supprimer un compte (admin only, pas l'admin principal)
    public function destroy(Utilisateur $compte)
    {
        if ($compte->role === 'administrateur') {
            return back()->withErrors(['Impossible de supprimer le compte administrateur.']);
        }
        $compte->delete();
        return redirect()->route('comptes.index')->with('success', 'Compte supprimé.');
    }

    // Helper: enlever les accents
    private function removeAccents(string $str): string
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str) ?: $str;
    }
}
