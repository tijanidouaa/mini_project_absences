@extends('layouts.app')

@section('page_title', 'Toutes les Absences')

@section('contenu')

<div class="page-header">
    <div>
        <h4>Gestion des Absences</h4>
        <p>Liste complète de toutes les absences enregistrées</p>
    </div>
    <a href="{{ route('admin.saisie.manuelle') }}" class="btn-app primary">
        <i class="bi bi-plus-lg"></i> Saisie manuelle
    </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon red"><i class="bi bi-x-circle"></i></div>
            <div>
                <div class="stat-number">{{ $absences->where('etat','non_justifiee')->count() }}</div>
                <div class="stat-label">Non justifiées</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
            <div>
                <div class="stat-number">{{ $absences->where('etat','justifiee')->count() }}</div>
                <div class="stat-label">Justifiées</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="bi bi-slash-circle"></i></div>
            <div>
                <div class="stat-number">{{ $absences->where('etat','annulee')->count() }}</div>
                <div class="stat-label">Annulées</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-people"></i></div>
            <div>
                <div class="stat-number">{{ $absences->count() }}</div>
                <div class="stat-label">Total absences</div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="app-card">
    <div class="app-card-header">
        <h6><i class="bi bi-table"></i> Liste des absences</h6>
        <span style="font-size:0.8rem; color:var(--text-muted)">
            {{ $absences->count() }} enregistrement(s)
        </span>
    </div>
    <div style="overflow-x:auto">
        <table class="app-table">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Élément</th>
                    <th>Type</th>
                    <th>Date & Heure</th>
                    <th>Enseignant</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absences as $absence)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px">
                            <img src="https://ui-avatars.com/api/?name={{ $absence->etudiant->nom_fr }}&background=e94560&color=fff&size=32"
                                 style="width:32px; height:32px; border-radius:8px">
                            <div>
                                <div style="font-weight:600; font-size:0.875rem">
                                    {{ $absence->etudiant->nom_fr }} {{ $absence->etudiant->prenom_fr }}
                                </div>
                                <div style="font-size:0.75rem; color:var(--text-muted)">
                                    {{ $absence->etudiant->massar }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $absence->element->titre }}</td>
                    <td>
                        <span style="background:#f1f5f9; padding:3px 10px; border-radius:6px; font-size:0.8rem">
                            {{ $absence->type_seance }}
                        </span>
                    </td>
                    <td>
                        <div style="font-size:0.875rem">{{ \Carbon\Carbon::parse($absence->date_heure)->format('d/m/Y') }}</div>
                        <div style="font-size:0.75rem; color:var(--text-muted)">{{ \Carbon\Carbon::parse($absence->date_heure)->format('H:i') }}</div>
                    </td>
                    <td>{{ $absence->enseignant->nom_fr }} {{ $absence->enseignant->prenom_fr }}</td>
                    <td>
                        @if($absence->etat === 'justifiee')
                            <span class="status-badge justified">Justifiée</span>
                        @elseif($absence->etat === 'annulee')
                            <span class="status-badge cancelled">Annulée</span>
                        @else
                            <span class="status-badge pending">Non justifiée</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:6px; flex-wrap:wrap">
                            <a href="{{ route('admin.absences.modifier', $absence->id) }}"
                               class="btn-app warning" style="font-size:0.78rem; padding:5px 10px">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.absences.justifier', $absence->id) }}">
                                @csrf
                                <button class="btn-app success" style="font-size:0.78rem; padding:5px 10px">
                                    <i class="bi bi-check"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.absences.annuler', $absence->id) }}">
                                @csrf
                                <button class="btn-app danger" style="font-size:0.78rem; padding:5px 10px">
                                    <i class="bi bi-x"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:40px; color:var(--text-muted)">
                        <i class="bi bi-inbox" style="font-size:2rem; display:block; margin-bottom:10px"></i>
                        Aucune absence enregistrée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection