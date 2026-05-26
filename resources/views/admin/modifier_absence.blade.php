@extends('layouts.app')

@section('contenu')
<h3 class="mb-4">Modifier une Absence</h3>

<form method="POST" action="{{ route('admin.absences.update', $absence->id) }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Type de séance</label>
        <select name="type_seance" class="form-select">
            <option value="Cours"   {{ $absence->type_seance === 'Cours'   ? 'selected' : '' }}>Cours</option>
            <option value="TD"      {{ $absence->type_seance === 'TD'      ? 'selected' : '' }}>TD</option>
            <option value="TP"      {{ $absence->type_seance === 'TP'      ? 'selected' : '' }}>TP</option>
            <option value="Visite"  {{ $absence->type_seance === 'Visite'  ? 'selected' : '' }}>Visite</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Date et heure</label>
        <input type="datetime-local" name="date_heure" class="form-control"
               value="{{ $absence->date_heure }}">
    </div>

    <div class="mb-3">
        <label class="form-label">État</label>
        <select name="etat" class="form-select">
            <option value="non_justifiee" {{ $absence->etat === 'non_justifiee' ? 'selected' : '' }}>Non justifiée</option>
            <option value="justifiee"     {{ $absence->etat === 'justifiee'     ? 'selected' : '' }}>Justifiée</option>
            <option value="annulee"       {{ $absence->etat === 'annulee'       ? 'selected' : '' }}>Annulée</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="{{ route('admin.absences') }}" class="btn btn-secondary">Retour</a>
</form>
@endsection