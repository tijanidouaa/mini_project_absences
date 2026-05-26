<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\LogConnexion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    // Afficher la page de connexion
    public function index()
    {
        return view('auth.login');
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required',
            'password' => 'required',
        ]);

        // Chercher l'utilisateur par login
        $utilisateur = Utilisateur::where('login', $request->login)->first();

        // Vérifier si le compte existe
        if (!$utilisateur) {
            return back()->withErrors(['login' => 'Login incorrect.']);
        }

        // Vérifier si le compte est verrouillé
        if ($utilisateur->locked == 1) {
            return back()->withErrors(['login' => 'Compte verrouillé.']);
        }

        // Vérifier si le compte est désactivé
        if ($utilisateur->enabled == 0) {
            return back()->withErrors(['login' => 'Compte désactivé.']);
        }

        // Vérifier le mot de passe
        if (!Hash::check($request->password, $utilisateur->password_hash)) {
            // Incrémenter les tentatives
            $utilisateur->tentatives += 1;

            // Verrouiller après 5 tentatives
            if ($utilisateur->tentatives >= 5) {
                $utilisateur->locked = 1;
            }
            $utilisateur->save();

            return back()->withErrors(['password' => 'Mot de passe incorrect.']);
        }

        // Réinitialiser les tentatives
        $utilisateur->tentatives = 0;
        $utilisateur->save();

        // Enregistrer la session
        Session::put('utilisateur_id', $utilisateur->id);
        Session::put('role', $utilisateur->role);
        Session::put('personne_id', $utilisateur->personne_id);

        // Enregistrer le log de connexion
        LogConnexion::create([
            'utilisateur_id' => $utilisateur->id,
            'adresse_ip'     => $request->ip(),
            'date_heure'     => now(),
        ]);

        // Rediriger selon le rôle
        if ($utilisateur->role === 'administrateur') {
            return redirect()->route('admin.absences');
        } elseif ($utilisateur->role === 'enseignant') {
            return redirect()->route('enseignant.saisie');
        } else {
            return redirect()->route('etudiant.fiche');
        }
    }

    // Déconnexion
    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}