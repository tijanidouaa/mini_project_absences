@extends('layouts.app')

@section('contenu')
<h3 class="mb-4">Réclamations en attente</h3>

<table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>Étudiant</th>
            <th>Message</th>
            <th>Répondre</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reclamations as $reclamation)
        <tr>
            <td>{{ $reclamation->etudiant->nom_fr }}</td>
            <td>{{ $reclamation->message }}</td>
            <td>
                <form method="POST"
                      action="{{ route('admin.reclamations.repondre', $reclamation->id) }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="reponse"
                               class="form-control" placeholder="Votre réponse" required>
                        <button class="btn btn-primary">Envoyer</button>
                    </div>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection