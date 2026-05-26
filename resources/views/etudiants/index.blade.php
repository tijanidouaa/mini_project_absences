@extends('layouts.app')
@section('title', 'Gestion des Étudiants')

@section('content')

{{-- Header --}}
<div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
    <div>
        <h1 style="font-size:1.5rem;font-weight:700;color:#0f1e3d">Gestion des Étudiants 👥</h1>
        <p style="color:#6b7a99;margin:0">{{ $etudiants->total() }} étudiant(s) au total</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.etudiants.create') }}" class="btn-primary-app">+ Ajouter</a>
        <a href="{{ route('admin.etudiants.csv', request()->query()) }}" class="btn-primary-app" style="background:#059669">⬇ CSV</a>
        <a href="{{ route('admin.etudiants.trashed') }}" class="btn-primary-app" style="background:#6b7280">🗑 Corbeille</a>
        <button onclick="window.print()" class="btn-primary-app" style="background:#7c3aed">🖨 Imprimer</button>
    </div>
</div>

{{-- Filtres --}}
<div class="form-card mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="form-label">Rechercher</label>
            <input type="text" name="search" class="form-control" placeholder="Nom, Massar, CIN..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Filtrer par niveau</label>
            <select name="niveau_id" class="form-select">
                <option value="">Tous les niveaux</option>
                @foreach($niveaux as $n)
                    <option value="{{ $n->id }}" {{ request('niveau_id') == $n->id ? 'selected' : '' }}>
                        {{ $n->filiere->alias }} — {{ $n->libelle }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn-primary-app w-100">🔍 Rechercher</button>
        </div>
    </form>
</div>

{{-- Tableau --}}
<div class="table-card">
    <div class="table-card-header">
        <h2>Liste des étudiants</h2>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th><th>Nom & Prénom</th><th>Massar</th>
                    <th>Niveau</th><th>Email</th><th>Tél</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($etudiants as $e)
                <tr>
                    <td style="color:#9aa4b8;font-size:.78rem">{{ $e->id }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:36px;height:36px;border-radius:50%;background:#2d7dd2;
                                display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:13px;flex-shrink:0">
                                {{ strtoupper(substr($e->prenom_fr,0,1).substr($e->nom_fr,0,1)) }}
                            </div>
                            <div>
                                <strong>{{ $e->nom_complet }}</strong>
                                @if($e->nom_ar)
                                    <br><small style="color:#9aa4b8;font-size:.72rem" dir="rtl">{{ $e->nom_complet_ar }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td><code style="font-size:.8rem">{{ $e->massar }}</code></td>
                    <td>{{ $e->niveau?->libelle ?? '—' }}</td>
                    <td style="font-size:.82rem">{{ $e->email ?? '—' }}</td>
                    <td style="font-size:.82rem">{{ $e->telephone ?? '—' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.etudiants.edit', $e) }}" class="btn-sm-edit">✏</a>
                            <a href="{{ route('admin.etudiants.historique', $e) }}" class="btn-sm-edit" title="Historique">📋</a>
                            <form method="POST" action="{{ route('admin.etudiants.destroy', $e) }}"
                                onsubmit="return confirm('Supprimer cet étudiant ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm-danger">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">Aucun étudiant trouvé.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($etudiants->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #eef1f6">
            {{ $etudiants->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
