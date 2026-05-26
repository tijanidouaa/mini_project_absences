<?php

namespace App\Http\Controllers;

use App\Models\LogConnexion;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private const MAX_ATTEMPTS = 5;

    public function showLogin()
    {
        if (Auth::check()) return $this->redirectByRole();
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required'    => 'L\'identifiant est requis.',
            'password.required' => 'Le mot de passe est requis.',
        ]);

        $login    = trim($request->input('login'));
        $password = $request->input('password');

        $utilisateur = Utilisateur::where('login', $login)->first();

        if (!$utilisateur) {
            return back()->withErrors(['login' => 'Identifiant ou mot de passe incorrect.'])->withInput(['login' => $login]);
        }

        if ($utilisateur->locked) {
            return back()->withErrors(['login' => 'Compte verrouillé. Contactez l\'administrateur.']);
        }

        if (!$utilisateur->enabled) {
            return back()->withErrors(['login' => 'Ce compte est désactivé.']);
        }

        if (!Hash::check($password, $utilisateur->password)) {
            $tentatives = $utilisateur->tentatives + 1;
            $locked     = $tentatives >= self::MAX_ATTEMPTS;
            $utilisateur->update(['tentatives' => $tentatives, 'locked' => $locked]);
            $remaining = self::MAX_ATTEMPTS - $tentatives;
            $msg = $locked
                ? 'Compte verrouillé après trop de tentatives.'
                : "Mot de passe incorrect. Encore {$remaining} tentative(s).";
            return back()->withErrors(['login' => $msg])->withInput(['login' => $login]);
        }

        // Connexion réussie
        $utilisateur->update(['tentatives' => 0]);
        Auth::login($utilisateur, $request->boolean('remember'));
        $request->session()->regenerate();

        LogConnexion::create([
            'utilisateur_id' => $utilisateur->id,
            'adresse_ip'     => $request->ip(),
        ]);

        return $this->redirectByRole();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Vous avez été déconnecté.');
    }

    private function redirectByRole()
    {
        return match(Auth::user()->role) {
            'administrateur' => redirect()->route('admin.dashboard'),
            'enseignant'     => redirect()->route('enseignant.dashboard'),
            'etudiant'       => redirect()->route('etudiant.dashboard'),
            default          => redirect('/'),
        };
    }
}
