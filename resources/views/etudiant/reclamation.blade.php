@extends('layouts.app')

@section('contenu')
<h3 class="mb-4">Mes Réclamations</h3>

<form method="POST" action="{{ route('etudiant.reclamation.envoyer') }}">
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
        <label class="form-label">Message</label>
        <textarea name="message" class="form-control" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Envoyer la réclamation</button>
</form>

<h5 class="mt-5">Mes réclamations en cours</h5>
<table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>Absence</th>
            <th>Message</th>
            <th>Réponse</th>
            <th>État</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reclamations as $reclamation)
        <tr>
            <td>{{ $reclamation->absence->element->titre }}</td>
            <td>{{ $reclamation->message }}</td>
            <td>{{ $reclamation->reponse ?? 'En attente' }}</td>
            <td>{{ $reclamation->etat }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection