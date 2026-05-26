@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat">
            <div class="stat-icon" style="background:#dbeafe">👥</div>
            <div class="stat-val">{{ $stats['etudiants'] }}</div>
            <div class="stat-lbl">Étudiants</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat">
            <div class="stat-icon" style="background:#d1fae5">🧑‍🏫</div>
            <div class="stat-val">{{ $stats['enseignants'] }}</div>
            <div class="stat-lbl">Enseignants</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat">
            <div class="stat-icon" style="background:#fef3c7">🔐</div>
            <div class="stat-val">{{ $stats['comptes'] }}</div>
            <div class="stat-lbl">Comptes</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat">
            <div class="stat-icon" style="background:#ede9fe">🏫</div>
            <div class="stat-val">{{ $stats['filieres'] }}</div>
            <div class="stat-lbl">Filières</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="table-card">
            <div class="table-card-header">
                <h2>Derniers étudiants ajoutés</h2>
                <a href="{{ route('admin.etudiants.index') }}" class="btn-primary-app" style="font-size:.78rem;padding:7px 14px">Voir tous →</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Nom & Prénom</th><th>Massar</th><th>Niveau</th></tr></thead>
                    <tbody>
                    @forelse($derniers_etudiants as $e)
                        <tr>
                            <td><strong>{{ $e->nom_complet }}</strong></td>
                            <td><code>{{ $e->massar }}</code></td>
                            <td>{{ $e->niveau?->libelle ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Aucun étudiant.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="table-card">
            <div class="table-card-header">
                <h2>Dernières connexions</h2>
                <a href="{{ route('admin.logs.connexion') }}" class="btn-primary-app" style="font-size:.78rem;padding:7px 14px">Voir tout →</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Login</th><th>IP</th><th>Date</th></tr></thead>
                    <tbody>
                    @forelse($derniers_connexions as $log)
                        <tr>
                            <td><strong>{{ $log->utilisateur?->login ?? '?' }}</strong></td>
                            <td><code style="font-size:.72rem">{{ $log->adresse_ip }}</code></td>
                            <td style="font-size:.78rem">{{ $log->created_at->format('d/m H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Aucune connexion.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
