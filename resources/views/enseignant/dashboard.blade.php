@extends('layouts.app')
@section('title', 'Espace Enseignant')

@section('content')
<div style="text-align:center;padding:60px 20px">
    <div style="font-size:64px;margin-bottom:16px">🧑‍🏫</div>
    <h1 style="font-size:1.6rem;font-weight:700;color:#0f1e3d">Bienvenue, {{ auth()->user()->login }}</h1>
    <p style="color:#6b7a99;margin-top:8px">
        L'interface enseignant (saisie des absences) fait partie de la <strong>Partie 2</strong> du projet.
    </p>
    <div style="margin-top:32px;padding:20px;background:#dbeafe;border-radius:14px;display:inline-block;max-width:400px;text-align:left">
        <p style="font-weight:700;color:#1e40af;margin:0 0 8px">📌 Partie 2 — À implémenter :</p>
        <ul style="color:#1e40af;font-size:.875rem;margin:0;padding-left:18px">
            <li>Saisie des absences (interface mobile)</li>
            <li>Consultation fiche absence étudiant</li>
            <li>Annulation d'absence</li>
            <li>Réception des demandes de permission</li>
        </ul>
    </div>
</div>
@endsection
