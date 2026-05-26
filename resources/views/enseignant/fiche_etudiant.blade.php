@extends('layouts.app')

@section('contenu')
<h3 class="mb-4">Fiche d'un Étudiant</h3>

<form method="POST" action="{{ route('enseignant.fiche.chercher') }}">
    @csrf
    <div class="input-group mb-4">
        <input type="text" name="identifiant" class="form-control"
               placeholder="Entrer le code Massar de l'étudiant" required>
        <button type="submit" class="btn btn-primary">Chercher</button>
    </div>
</form>

@isset($etudiant)
<div class="card mb-4">
    <div class="card-body">
        <h5>{{ $etudiant->nom_fr }} {{ $etudiant->prenom_fr }}</h5>
        <p>Massar : {{ $etudiant->massar }}</p>
        <p>Email : {{ $etudiant->email }}</p>
    </div>
</div>

<h5>Absences de l'année en cours</h5>
<table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>Élément</th>
            <th>Type</th>
            <th>Date</th>
            <th>État</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absences as $absence)
        <tr>
            <td>{{ $absence->element->titre }}</td>
            <td>{{ $absence->type_seance }}</td>
            <td>{{ $absence->date_heure }}</td>
            <td>{{ $absence->etat }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endisset
@endsection