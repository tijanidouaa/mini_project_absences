<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\LogConnexion;
use App\Models\Utilisateur;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'etudiants'   => Etudiant::count(),
            'enseignants' => Enseignant::count(),
            'comptes'     => Utilisateur::where('role', '!=', 'administrateur')->count(),
            'filieres'    => Filiere::count(),
        ];

        $derniers_etudiants = Etudiant::with('niveau.filiere')
            ->latest()->take(5)->get();

        $derniers_connexions = LogConnexion::with('utilisateur')
            ->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'derniers_etudiants', 'derniers_connexions'));
    }

    public function logsConnexion()
    {
        $logs = LogConnexion::with('utilisateur')->latest()->paginate(30);
        return view('admin.logs_connexion', compact('logs'));
    }
}
