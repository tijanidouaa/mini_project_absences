<?php

use Illuminate\Support\Facades\Route;

// Controllers Auth
use App\Http\Controllers\Auth\LoginController;

// Controllers Enseignant
use App\Http\Controllers\Enseignant\SaisieAbsenceController;
use App\Http\Controllers\Enseignant\AnnulationAbsenceController;
use App\Http\Controllers\Enseignant\FicheEtudiantController;
use App\Http\Controllers\Enseignant\DemandePermissionController as EnseignantDemandeController;

// Controllers Etudiant
use App\Http\Controllers\Etudiant\FicheAbsenceController;
use App\Http\Controllers\Etudiant\JustificationController;
use App\Http\Controllers\Etudiant\ReclamationController;
use App\Http\Controllers\Etudiant\DemandePermissionController as EtudiantDemandeController;
use App\Http\Controllers\Etudiant\ProfilController;

// Controllers Admin
use App\Http\Controllers\Admin\AbsenceController;
use App\Http\Controllers\Admin\JustificationController as AdminJustificationController;
use App\Http\Controllers\Admin\ReclamationController as AdminReclamationController;
use App\Http\Controllers\Admin\SaisieManuelleController;

// ============================================================
// AUTHENTIFICATION
// ============================================================
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================================
// ENSEIGNANT
// ============================================================
Route::prefix('enseignant')->name('enseignant.')->group(function () {
   
    Route::post('/saisie/valider', [SaisieAbsenceController::class, 'valider'])->name('saisie.valider');
    Route::get('/saisie', [SaisieAbsenceController::class, 'index'])->name('saisie');
    Route::post('/saisie/etudiants', [SaisieAbsenceController::class, 'getEtudiants'])->name('saisie.etudiants');
    Route::get('/saisie/etudiants', [SaisieAbsenceController::class, 'index'])->name('saisie.etudiants.get');
    Route::get('/annulation', [AnnulationAbsenceController::class, 'index'])->name('annulation');
    Route::post('/annulation/{id}', [AnnulationAbsenceController::class, 'annuler'])->name('annulation.annuler');

    Route::get('/fiche-etudiant', [FicheEtudiantController::class, 'index'])->name('fiche');
    Route::post('/fiche-etudiant/chercher', [FicheEtudiantController::class, 'chercher'])->name('fiche.chercher');

    Route::get('/demandes', [EnseignantDemandeController::class, 'index'])->name('demandes');
    Route::post('/demandes/{id}/repondre', [EnseignantDemandeController::class, 'repondre'])->name('demandes.repondre');
});

// ============================================================
// ETUDIANT
// ============================================================
Route::prefix('etudiant')->name('etudiant.')->group(function () {
    Route::get('/fiche', [FicheAbsenceController::class, 'index'])->name('fiche');

    Route::get('/justification', [JustificationController::class, 'index'])->name('justification');
    Route::post('/justification/envoyer', [JustificationController::class, 'envoyer'])->name('justification.envoyer');

    Route::get('/reclamation', [ReclamationController::class, 'index'])->name('reclamation');
    Route::post('/reclamation/envoyer', [ReclamationController::class, 'envoyer'])->name('reclamation.envoyer');

    Route::get('/demande-permission', [EtudiantDemandeController::class, 'index'])->name('demande');
    Route::post('/demande-permission/envoyer', [EtudiantDemandeController::class, 'envoyer'])->name('demande.envoyer');

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/profil/modifier', [ProfilController::class, 'modifier'])->name('profil.modifier');
});

// ============================================================
// ADMIN
// ============================================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/absences', [AbsenceController::class, 'index'])->name('absences');
    Route::get('/absences/{id}/modifier', [AbsenceController::class, 'modifier'])->name('absences.modifier');
    Route::post('/absences/{id}/update', [AbsenceController::class, 'update'])->name('absences.update');
    Route::post('/absences/{id}/annuler', [AbsenceController::class, 'annuler'])->name('absences.annuler');
    Route::post('/absences/{id}/justifier', [AbsenceController::class, 'justifier'])->name('absences.justifier');

    Route::get('/justifications', [AdminJustificationController::class, 'index'])->name('justifications');
    Route::post('/justifications/{id}/traiter', [AdminJustificationController::class, 'traiter'])->name('justifications.traiter');

    Route::get('/reclamations', [AdminReclamationController::class, 'index'])->name('reclamations');
    Route::post('/reclamations/{id}/repondre', [AdminReclamationController::class, 'repondre'])->name('reclamations.repondre');

    Route::get('/saisie-manuelle', [SaisieManuelleController::class, 'index'])->name('saisie.manuelle');
    Route::post('/saisie-manuelle/verifier', [SaisieManuelleController::class, 'verifier'])->name('saisie.manuelle.verifier');
    Route::post('/saisie-manuelle/valider', [SaisieManuelleController::class, 'valider'])->name('saisie.manuelle.valider');
});