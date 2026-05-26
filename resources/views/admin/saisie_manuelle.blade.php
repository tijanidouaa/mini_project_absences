@extends('layouts.app')

@section('page_title', 'Saisie Manuelle des Absences')

@section('contenu')
<div class="card">
    <div class="card-header">
        <i class="bi bi-keyboard me-2"></i> Saisie Manuelle des Absences
    </div>
    <div class="card-body p-4">

        <form method="POST" action="{{ route('admin.saisie.manuelle.verifier') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Identifiants Massar des absents</label>
                <input type="text" name="identifiants" class="form-control"
                       placeholder="ex: M123456, M789012, M345678"
                       required>
                <small class="text-muted">Séparez les identifiants par des virgules</small>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Élément</label>
                    <select name="element_id" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        @foreach($elements as $element)
                        <option value="{{ $element->id }}">{{ $element->titre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Type de séance</label>
                    <select name="type_seance" class="form-select" required>
                        <option value="Cours">Cours</option>
                        <option value="TD">TD</option>
                        <option value="TP">TP</option>
                        <option value="Visite">Visite</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Date et heure</label>
                    <input type="datetime-local" name="date_heure"
                           class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search me-2"></i> Vérifier les étudiants
            </button>
        </form>

        {{-- Affichage des étudiants trouvés --}}
        @isset($etudiants_trouves)
        <hr class="my-4">
        <h5 class="mb-3">Étudiants trouvés</h5>

        <div class="row mb-4">
            @foreach($etudiants_trouves as $etudiant)
            <div class="col-md-2 text-center mb-3">
                <div class="p-3 border rounded-3 bg-light">
                    <img src="{{ $etudiant->photo ? asset('storage/'.$etudiant->photo) : 'https://ui-avatars.com/api/?name='.$etudiant->nom_fr.'&background=e94560&color=fff' }}"
                         class="rounded-circle mb-2"
                         width="70" height="70"
                         style="object-fit:cover">
                    <p class="mb-0 small fw-bold">{{ $etudiant->nom_fr }}</p>
                    <p class="mb-0 small text-muted">{{ $etudiant->prenom_fr }}</p>
                </div>
            </div>
            @endforeach
        </div>

        @if(isset($etudiants_inconnus) && count($etudiants_inconnus) > 0)
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Identifiants non trouvés : <strong>{{ implode(', ', $etudiants_inconnus) }}</strong>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.saisie.manuelle.valider') }}">
            @csrf
            <button class="btn btn-danger">
                <i class="bi bi-check-circle me-2"></i> Valider définitivement les absences
            </button>
        </form>
        @endisset

    </div>
</div>
@endsection