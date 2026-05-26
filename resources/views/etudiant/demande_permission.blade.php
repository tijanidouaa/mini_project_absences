@extends('layouts.app')

@section('contenu')
<h3 class="mb-4">Demande de Permission</h3>

<form method="POST" action="{{ route('etudiant.demande.envoyer') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Enseignant</label>
        <select name="enseignant_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach($enseignants as $enseignant)
            <option value="{{ $enseignant->id }}">
                {{ $enseignant->nom_fr }} {{ $enseignant->prenom_fr }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Message</label>
        <textarea name="message" class="form-control" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>

<h5 class="mt-5">Mes demandes</h5>
<table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>Enseignant</th>
            <th>Message</th>
            <th>Réponse</th>
            <th>État</th>
        </tr>
    </thead>
    <tbody>
        @foreach($demandes as $demande)
        <tr>
            <td>{{ $demande->enseignant->nom_fr }}</td>
            <td>{{ $demande->message }}</td>
            <td>{{ $demande->reponse ?? 'En attente' }}</td>
            <td>{{ $demande->etat }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection