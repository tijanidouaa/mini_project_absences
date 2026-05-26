@extends('layouts.app')

@section('contenu')
<h3 class="mb-4">Mon Profil</h3>

<form method="POST" action="{{ route('etudiant.profil.modifier') }}"
      enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ $etudiant->email }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Téléphone</label>
        <input type="text" name="telephone" class="form-control"
               value="{{ $etudiant->telephone }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Photo</label>
        @if($etudiant->photo)
            <div class="mb-2">
                <img src="{{ asset('storage/'.$etudiant->photo) }}"
                     width="100" class="rounded-circle">
            </div>
        @endif
        <input type="file" name="photo" class="form-control"
               accept=".jpg,.jpeg,.png">
    </div>

    <button type="submit" class="btn btn-primary">Modifier</button>
</form>
@endsection