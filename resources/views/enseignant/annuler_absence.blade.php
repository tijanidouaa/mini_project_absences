@extends('layouts.app')

@section('contenu')
<h3 class="mb-4">Annuler une Absence</h3>

<table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>Étudiant</th>
            <th>Élément</th>
            <th>Type</th>
            <th>Date</th>
            <th>État</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absences as $absence)
        <tr>
            <td>{{ $absence->etudiant->nom_fr }} {{ $absence->etudiant->prenom_fr }}</td>
            <td>{{ $absence->element->titre }}</td>
            <td>{{ $absence->type_seance }}</td>
            <td>{{ $absence->date_heure }}</td>
            <td>{{ $absence->etat }}</td>
            <td>
                @if($absence->etat !== 'annulee')
                <form method="POST" action="{{ route('enseignant.annulation.annuler', $absence->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm">Annuler</button>
                </form>
                @else
                    <span class="text-muted">Déjà annulée</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection