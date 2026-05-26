@extends('layouts.app')
@section('title', 'Historique — ' . $etudiant->nom_complet)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.etudiants.index') }}" class="btn-sm-edit">← Retour</a>
    <div>
        <h1 style="font-size:1.5rem;font-weight:700;color:#0f1e3d;margin:0">Historique des modifications 📋</h1>
        <p style="color:#6b7a99;margin:0">{{ $etudiant->nom_complet }} — Massar : {{ $etudiant->massar }}</p>
    </div>
</div>

<div class="table-card">
    <div class="table-card-header"><h2>Journal ({{ $historique->total() }} entrée(s))</h2></div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Date</th><th>Champ modifié</th><th>Avant</th><th>Après</th><th>Par</th></tr></thead>
            <tbody>
            @forelse($historique as $h)
                <tr>
                    <td style="font-size:.8rem;color:#6b7a99">{{ $h->created_at->format('d/m/Y H:i') }}</td>
                    <td><code>{{ $h->champ_modifie }}</code></td>
                    <td style="color:#e53e3e;font-size:.85rem">{{ $h->ancienne_valeur ?? '—' }}</td>
                    <td style="color:#38a169;font-size:.85rem">{{ $h->nouvelle_valeur ?? '—' }}</td>
                    <td><strong>{{ $h->utilisateur?->login ?? '?' }}</strong></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">Aucune modification enregistrée.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($historique->hasPages())
        <div style="padding:14px 20px">{{ $historique->links() }}</div>
    @endif
</div>
@endsection
