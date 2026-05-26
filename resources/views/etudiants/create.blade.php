{{-- create.blade.php --}}
@extends('layouts.app')
@section('title', 'Ajouter un étudiant')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.etudiants.index') }}" class="btn-sm-edit">← Retour</a>
    <h1 style="font-size:1.5rem;font-weight:700;color:#0f1e3d;margin:0">Ajouter un étudiant</h1>
</div>

<div class="form-card" style="max-width:800px">
    <form method="POST" action="{{ route('admin.etudiants.store') }}">
        @csrf
        @include('etudiants._form')
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn-primary-app">💾 Enregistrer</button>
            <a href="{{ route('admin.etudiants.index') }}" class="btn btn-light" style="border-radius:10px">Annuler</a>
        </div>
    </form>
</div>
@endsection
