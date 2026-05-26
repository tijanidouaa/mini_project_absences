@extends('layouts.app')

@section('contenu')
<h3 class="mb-4">Justifications en attente</h3>

<table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>Étudiant</th>
            <th>Absence</th>
            <th>Fichier</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($justifications as $justification)
        <tr>
            <td>{{ $justification->absence->etudiant->nom_fr }}</td>
            <td>{{ $justification->absence->element->titre }}</td>
            <td>
                <a href="{{ asset('storage/'.$justification->fichier) }}"
                   target="_blank">Voir le fichier</a>
            </td>
            <td>
                <form method="POST"
                      action="{{ route('admin.justifications.traiter', $justification->id) }}"
                      style="display:inline">
                    @csrf
                    <button name="etat" value="acceptee" class="btn btn-success btn-sm">Accepter</button>
                    <button name="etat" value="refusee"  class="btn btn-danger btn-sm">Refuser</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection