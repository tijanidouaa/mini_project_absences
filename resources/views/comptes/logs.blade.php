@extends('layouts.app')
@section('title', 'Logs — ' . $compte->login)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.comptes.index') }}" class="btn-sm-edit">← Retour</a>
    <div>
        <h1 style="font-size:1.5rem;font-weight:700;color:#0f1e3d;margin:0">
            Logs : <span style="color:#2d7dd2">{{ $compte->login }}</span>
        </h1>
        <p style="color:#6b7a99;margin:0">
            <span class="badge-role badge-{{ $compte->role }}">{{ $compte->role }}</span>
        </p>
    </div>
</div>

<div class="row g-4">
    {{-- Connexions --}}
    <div class="col-lg-5">
        <div class="table-card">
            <div class="table-card-header">
                <h2>🔐 Connexions ({{ $connexions->total() }})</h2>
            </div>
            <div class="table-responsive" style="max-height:450px;overflow-y:auto">
                <table class="table mb-0">
                    <thead><tr><th>Date & Heure</th><th>Adresse IP</th></tr></thead>
                    <tbody>
                    @forelse($connexions as $c)
                        <tr>
                            <td style="font-size:.82rem">{{ $c->created_at->format('d/m/Y H:i:s') }}</td>
                            <td><code style="font-size:.78rem">{{ $c->adresse_ip }}</code></td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center py-4 text-muted">Aucune connexion enregistrée.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($connexions->hasPages())
                <div style="padding:12px 18px;border-top:1px solid #eef1f6">
                    {{ $connexions->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Actions --}}
    <div class="col-lg-7">
        <div class="table-card">
            <div class="table-card-header">
                <h2>📋 Pages visitées ({{ $actions->total() }})</h2>
            </div>
            <div class="table-responsive" style="max-height:450px;overflow-y:auto">
                <table class="table mb-0">
                    <thead><tr><th>Date & Heure</th><th>Page</th></tr></thead>
                    <tbody>
                    @forelse($actions as $a)
                        <tr>
                            <td style="font-size:.82rem;color:#6b7a99">{{ $a->created_at->format('d/m/Y H:i') }}</td>
                            <td><code style="font-size:.78rem">{{ $a->page_visitee }}</code></td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center py-4 text-muted">Aucune action enregistrée.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($actions->hasPages())
                <div style="padding:12px 18px;border-top:1px solid #eef1f6">
                    {{ $actions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
