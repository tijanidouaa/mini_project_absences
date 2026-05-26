@extends('layouts.app')

@section('page_title', 'Saisie des Absences')

@section('contenu')

<div class="page-header">
    <div>
        <h4>Saisie des Absences</h4>
        <p>Sélectionnez la séance puis marquez les étudiants absents</p>
    </div>
</div>

{{-- Étape 1 : Informations de la séance --}}
<div class="app-card mb-4">
    <div class="app-card-header">
        <h6><i class="bi bi-info-circle"></i> Informations de la séance</h6>
    </div>
    <div class="app-card-body">
        <form method="POST" action="{{ route('enseignant.saisie.etudiants') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Type de séance</label>
                    <select name="type_seance" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="Cours">Cours</option>
                        <option value="TD">TD</option>
                        <option value="TP">TP</option>
                        <option value="Visite">Visite</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Élément</label>
                    <select name="element_id" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        @foreach($elements as $element)
                        <option value="{{ $element->id }}">{{ $element->titre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date et heure</label>
                    <input type="datetime-local" name="date_heure" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Classe</label>
                    <select name="niveau_id" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}">{{ $niveau->libelle }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn-app primary">
                    <i class="bi bi-search"></i> Charger les étudiants
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Étape 2 : Liste des étudiants --}}
@isset($etudiants)
<form method="POST" action="{{ route('enseignant.saisie.valider') }}">
    @csrf
    <input type="hidden" name="element_id"  value="{{ request('element_id') }}">
    <input type="hidden" name="type_seance" value="{{ request('type_seance') }}">
    <input type="hidden" name="date_heure"  value="{{ request('date_heure') }}">

    <div class="app-card">
        <div class="app-card-header">
            <h6><i class="bi bi-people"></i> Étudiants de la classe — Cliquez pour marquer absent</h6>
            <span style="font-size:0.8rem; color:var(--text-muted)">
                {{ $etudiants->count() }} étudiant(s)
            </span>
        </div>
        <div class="app-card-body">

            @if($etudiants->isEmpty())
                <div style="text-align:center; padding:40px; color:var(--text-muted)">
                    <i class="bi bi-people" style="font-size:2rem; display:block; margin-bottom:10px"></i>
                    Aucun étudiant dans cette classe
                </div>
            @else
                <div class="row g-3 mb-4">
                    @foreach($etudiants as $etudiant)
                    <div class="col-6 col-md-2">
                        <div class="student-card" onclick="toggleAbsent(this)">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($etudiant->nom_fr.' '.$etudiant->prenom_fr) }}&background=e94560&color=fff&size=64"
                                 alt="{{ $etudiant->nom_fr }}">
                            <div class="name">{{ $etudiant->nom_fr }}</div>
                            <div class="name" style="font-weight:400; color:var(--text-muted)">
                                {{ $etudiant->prenom_fr }}
                            </div>
                            <div class="absent-mark">
                                <i class="bi bi-x-circle-fill"></i> Absent
                            </div>
                            <input type="checkbox"
                                   name="absents[]"
                                   value="{{ $etudiant->id }}"
                                   style="display:none">
                        </div>
                    </div>
                    @endforeach
                </div>

                <div style="display:flex; align-items:center; justify-content:space-between; padding-top:15px; border-top:1px solid var(--border)">
                    <div style="font-size:0.85rem; color:var(--text-muted)">
                        <i class="bi bi-info-circle me-1"></i>
                        Cliquez sur les étudiants absents puis validez
                    </div>
                    <button type="submit" class="btn-app primary">
                        <i class="bi bi-check-circle"></i> Valider les absences
                    </button>
                </div>
            @endif

        </div>
    </div>
</form>
@endisset

<script>
function toggleAbsent(card) {
    card.classList.toggle('absent');
    const checkbox = card.querySelector('input[type=checkbox]');
    checkbox.checked = card.classList.contains('absent');
}
</script>

@endsection