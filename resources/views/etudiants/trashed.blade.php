@extends('layouts.app')
@section('title', 'Corbeille — Étudiants supprimés')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.etudiants.index') }}" class="btn-sm-edit">← Retour</a>
    <h1 style="font-size:1.5rem;font-weight:700;color:#0f1e3d;margin:0">🗑 Corbeille</h1>
</div>

<div class="table-card">
    <div class="table-card-header">
        <h2>Étudiants supprimés ({{ $etudiants->total() }})</h2>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Nom & Prénom</th><th>Massar</th><th>Supprimé le</th><th>Action</th></tr></thead>
            <tbody>
            @forelse($etudiants as $e)
                <tr>
                    <td><strong>{{ $e->nom_complet }}</strong></td>
                    <td><code>{{ $e->massar }}</code></td>
                    <td>{{ $e->deleted_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.etudiants.restore', $e->id) }}">
                            @csrf
                            <button type="submit" class="btn-sm-green">♻ Restaurer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4 text-muted">Corbeille vide.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($etudiants->hasPages())
        <div style="padding:14px 20px">{{ $etudiants->links() }}</div>
    @endif
</div>
@endsection
