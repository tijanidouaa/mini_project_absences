@extends('layouts.app')

@section('contenu')
<h3 class="mb-4">Mes Absences</h3>

<h5>Année en cours (2025/2026)</h5>
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
            <td>
                <span class="badge
                    {{ $absence->etat === 'justifiee' ? 'bg-success' :
                      ($absence->etat === 'annulee' ? 'bg-secondary' : 'bg-danger') }}">
                    {{ $absence->etat }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h5 class="mt-4">Années passées</h5>
<table class="table table-bordered">
    <thead class="table-secondary">
        <tr>
            <th>Élément</th>
            <th>Type</th>
            <th>Date</th>
            <th>Année</th>
            <th>État</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absences_passees as $absence)
        <tr>
            <td>{{ $absence->element->titre }}</td>
            <td>{{ $absence->type_seance }}</td>
            <td>{{ $absence->date_heure }}</td>
            <td>{{ $absence->annee_academique }}</td>
            <td>{{ $absence->etat }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection