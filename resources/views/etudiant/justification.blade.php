@extends('layouts.app')

@section('contenu')
<h3 class="mb-4">Envoyer une Justification</h3>

<form method="POST" action="{{ route('etudiant.justification.envoyer') }}"
      enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">Sélectionner l'absence</label>
        <select name="absence_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach($absences as $absence)
            <option value="{{ $absence->id }}">
                {{ $absence->element->titre }} - {{ $absence->date_heure }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Fichier justificatif (PDF, JPG, PNG)</label>
        <input type="file" name="justificatif" class="form-control"
               accept=".pdf,.jpg,.jpeg,.png" required>
    </div>

    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>
@endsection