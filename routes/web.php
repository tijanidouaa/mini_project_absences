<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\StructureController;
use Illuminate\Support\Facades\Route;

// ──────────────────────────────────────────────
// Auth
// ──────────────────────────────────────────────
Route::get('/',       fn() => redirect()->route('login'));
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ──────────────────────────────────────────────
// Zone Admin
// ──────────────────────────────────────────────
Route::middleware(['auth', 'role:administrateur', 'log.action'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard',       [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/logs-connexion',  [AdminController::class, 'logsConnexion'])->name('logs.connexion');

    // ── Module 1 : Étudiants ──
    Route::get('/etudiants',               [EtudiantController::class, 'index'])->name('etudiants.index');
    Route::get('/etudiants/create',        [EtudiantController::class, 'create'])->name('etudiants.create');
    Route::post('/etudiants',              [EtudiantController::class, 'store'])->name('etudiants.store');
    Route::get('/etudiants/{etudiant}/edit',     [EtudiantController::class, 'edit'])->name('etudiants.edit');
    Route::put('/etudiants/{etudiant}',          [EtudiantController::class, 'update'])->name('etudiants.update');
    Route::delete('/etudiants/{etudiant}',       [EtudiantController::class, 'destroy'])->name('etudiants.destroy');
    Route::get('/etudiants/trashed',             [EtudiantController::class, 'trashed'])->name('etudiants.trashed');
    Route::post('/etudiants/{id}/restore',       [EtudiantController::class, 'restore'])->name('etudiants.restore');
    Route::get('/etudiants/{etudiant}/historique',[EtudiantController::class, 'historique'])->name('etudiants.historique');
    Route::get('/etudiants/export-csv',          [EtudiantController::class, 'exportCsv'])->name('etudiants.csv');

    // ── Module 4 : Comptes ──
    Route::get('/comptes',                       [CompteController::class, 'index'])->name('comptes.index');
    Route::post('/comptes',                      [CompteController::class, 'store'])->name('comptes.store');
    Route::post('/comptes/{compte}/toggle-enabled',[CompteController::class,'toggleEnabled'])->name('comptes.toggle');
    Route::post('/comptes/{compte}/toggle-locked', [CompteController::class,'toggleLocked'])->name('comptes.lock');
    Route::post('/comptes/{compte}/reset-password',[CompteController::class,'resetPassword'])->name('comptes.reset');
    Route::post('/comptes/{compte}/change-role',   [CompteController::class,'changeRole'])->name('comptes.role');
    Route::get('/comptes/{compte}/logs',           [CompteController::class,'logs'])->name('comptes.logs');
    Route::delete('/comptes/{compte}',             [CompteController::class,'destroy'])->name('comptes.destroy');
    Route::get('/comptes/search-person',           [CompteController::class,'searchPerson'])->name('comptes.search');

    // ── Module 3 : Structure Pédagogique ──
    Route::get('/structure/filieres',            [StructureController::class, 'filieres'])->name('structure.filieres');
    Route::post('/structure/filieres',           [StructureController::class, 'storeFiliere'])->name('structure.filieres.store');
    Route::put('/structure/filieres/{filiere}',  [StructureController::class, 'updateFiliere'])->name('structure.filieres.update');
    Route::delete('/structure/filieres/{filiere}',[StructureController::class,'destroyFiliere'])->name('structure.filieres.destroy');

    Route::get('/structure/niveaux',             [StructureController::class, 'niveaux'])->name('structure.niveaux');
    Route::post('/structure/niveaux',            [StructureController::class, 'storeNiveau'])->name('structure.niveaux.store');
    Route::put('/structure/niveaux/{niveau}',    [StructureController::class, 'updateNiveau'])->name('structure.niveaux.update');
    Route::delete('/structure/niveaux/{niveau}', [StructureController::class, 'destroyNiveau'])->name('structure.niveaux.destroy');

    Route::get('/structure/modules',             [StructureController::class, 'modules'])->name('structure.modules');
    Route::post('/structure/modules',            [StructureController::class, 'storeModule'])->name('structure.modules.store');
    Route::put('/structure/modules/{module}',    [StructureController::class, 'updateModule'])->name('structure.modules.update');
    Route::delete('/structure/modules/{module}', [StructureController::class, 'destroyModule'])->name('structure.modules.destroy');

    Route::get('/structure/elements',            [StructureController::class, 'elements'])->name('structure.elements');
    Route::post('/structure/elements',           [StructureController::class, 'storeElement'])->name('structure.elements.store');
    Route::put('/structure/elements/{element}',  [StructureController::class, 'updateElement'])->name('structure.elements.update');
    Route::delete('/structure/elements/{element}',[StructureController::class,'destroyElement'])->name('structure.elements.destroy');

    Route::get('/structure/import',              [StructureController::class, 'importForm'])->name('structure.import');
    Route::post('/structure/import',             [StructureController::class, 'import'])->name('structure.import.post');
});

// ──────────────────────────────────────────────
// Zone Enseignant (pour la partie 2)
// ──────────────────────────────────────────────
Route::middleware(['auth', 'role:enseignant', 'log.action'])
    ->prefix('enseignant')->name('enseignant.')
    ->group(function () {
    Route::get('/dashboard', fn() => view('enseignant.dashboard'))->name('dashboard');
});

// ──────────────────────────────────────────────
// Zone Étudiant (pour la partie 2)
// ──────────────────────────────────────────────
Route::middleware(['auth', 'role:etudiant', 'log.action'])
    ->prefix('etudiant')->name('etudiant.')
    ->group(function () {
    Route::get('/dashboard', fn() => view('etudiant.dashboard'))->name('dashboard');
});
