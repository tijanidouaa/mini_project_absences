@extends('layouts.app')
@section('title', 'Logs de Connexion')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 style="font-size:1.5rem;font-weight:700;color:#0f1e3d">Logs de Connexion 📋</h1>
        <p style="color:#6b7a99;margin:0">Historique de toutes les connexions à l'application</p>
    </div>
</div>

<div class="table-card">
    <div class="table-card-header">
        <h2>{{ $logs->total() }} connexion(s)</h2>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr><th>Login</th><th>Rôle</th><th>Adresse IP</th><th>Date & Heure</th></tr>
            </thead>
            <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>
                        <strong>{{ $log->utilisateur?->login ?? '?' }}</strong>
                    </td>
                    <td>
                        @if($log->utilisateur)
                            <span class="badge-role badge-{{ $log->utilisateur->role }}">{{ $log->utilisateur->role }}</span>
                        @endif
                    </td>
                    <td><code style="font-size:.82rem">{{ $log->adresse_ip }}</code></td>
                    <td style="font-size:.85rem">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4 text-muted">Aucune connexion enregistrée.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #eef1f6">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
