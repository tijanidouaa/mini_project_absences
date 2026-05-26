@extends('layouts.app')

@section('contenu')
<h3 class="mb-4">Demandes de Permission</h3>

<table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>Étudiant</th>
            <th>Message</th>
            <th>État</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($demandes as $demande)
        <tr>
            <td>{{ $demande->etudiant->nom_fr }} {{ $demande->etudiant->prenom_fr }}</td>
            <td>{{ $demande->message }}</td>
            <td>{{ $demande->etat }}</td>
            <td>
                @if($demande->etat === 'en_attente')
                <form method="POST" action="{{ route('enseignant.demandes.repondre', $demande->id) }}">
                    @csrf
                    <button name="reponse" value="OK" class="btn btn-success btn-sm">OK</button>
                    <button name="reponse" value="Non" class="btn btn-danger btn-sm">Non</button>
                </form>
                @else
                    <span class="text-muted">Réponse : {{ $demande->reponse }}</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection