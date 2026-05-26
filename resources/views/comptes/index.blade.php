@extends('layouts.app')
@section('title', 'Gestion des Comptes')

@section('content')
<div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
    <div>
        <h1 style="font-size:1.5rem;font-weight:700;color:#0f1e3d">Gestion des Comptes 🔐</h1>
        <p style="color:#6b7a99;margin:0">{{ $comptes->total() }} compte(s)</p>
    </div>
    <button class="btn-primary-app" data-bs-toggle="modal" data-bs-target="#modalCreate">+ Créer un compte</button>
</div>

<div class="table-card">
    <div class="table-card-header"><h2>Tous les comptes</h2></div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr><th>Login</th><th>Nom</th><th>Rôle</th><th>Statut</th><th>Verrou</th><th>Tentatives</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse($comptes as $c)
                <tr>
                    <td><strong>{{ $c->login }}</strong></td>
                    <td style="font-size:.85rem">{{ $c->nom_complet }}</td>
                    <td><span class="badge-role badge-{{ $c->role }}">{{ $c->role }}</span></td>
                    <td>
                        @if($c->enabled)
                            <span class="badge-active">✅ Actif</span>
                        @else
                            <span class="badge-inactive">❌ Désactivé</span>
                        @endif
                    </td>
                    <td>
                        @if($c->locked)
                            <span style="color:#e53e3e;font-size:.82rem;font-weight:600">🔒 Verrouillé</span>
                        @else
                            <span style="color:#9aa4b8;font-size:.82rem">🔓 Libre</span>
                        @endif
                    </td>
                    <td>{{ $c->tentatives }}</td>
                    <td>
                        @if($c->role !== 'administrateur')
                        <div class="d-flex gap-1 flex-wrap">
                            {{-- Toggle actif --}}
                            <form method="POST" action="{{ route('admin.comptes.toggle', $c) }}">
                                @csrf
                                <button type="submit" class="btn-sm-edit" title="{{ $c->enabled ? 'Désactiver' : 'Activer' }}">
                                    {{ $c->enabled ? '⏸' : '▶' }}
                                </button>
                            </form>
                            {{-- Toggle lock --}}
                            <form method="POST" action="{{ route('admin.comptes.lock', $c) }}">
                                @csrf
                                <button type="submit" class="btn-sm-edit" title="{{ $c->locked ? 'Déverrouiller' : 'Verrouiller' }}">
                                    {{ $c->locked ? '🔓' : '🔒' }}
                                </button>
                            </form>
                            {{-- Reset password --}}
                            <form method="POST" action="{{ route('admin.comptes.reset', $c) }}"
                                onsubmit="return confirm('Réinitialiser le mot de passe ?')">
                                @csrf
                                <button type="submit" class="btn-sm-edit" title="Réinitialiser mdp">🔑</button>
                            </form>
                            {{-- Change role --}}
                            <form method="POST" action="{{ route('admin.comptes.role', $c) }}" class="d-inline-flex gap-1">
                                @csrf
                                <select name="role" class="form-select form-select-sm" style="width:110px;border-radius:8px;font-size:.78rem">
                                    <option value="etudiant"      {{ $c->role==='etudiant'?'selected':'' }}>Étudiant</option>
                                    <option value="enseignant"    {{ $c->role==='enseignant'?'selected':'' }}>Enseignant</option>
                                    <option value="administrateur"{{ $c->role==='administrateur'?'selected':'' }}>Admin</option>
                                </select>
                                <button type="submit" class="btn-sm-edit">💾</button>
                            </form>
                            {{-- Logs --}}
                            <a href="{{ route('admin.comptes.logs', $c) }}" class="btn-sm-edit" title="Voir logs">📋</a>
                            {{-- Supprimer --}}
                            <form method="POST" action="{{ route('admin.comptes.destroy', $c) }}"
                                onsubmit="return confirm('Supprimer ce compte ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm-danger">🗑</button>
                            </form>
                        </div>
                        @else
                            <span style="color:#9aa4b8;font-size:.8rem">— admin —</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">Aucun compte.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($comptes->hasPages())
        <div style="padding:14px 20px">{{ $comptes->links() }}</div>
    @endif
</div>

{{-- Modal créer compte --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">➕ Créer un compte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.comptes.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Type de compte</label>
                        <select name="role" id="roleSelect" class="form-select" onchange="updateLabel()">
                            <option value="etudiant">Étudiant</option>
                            <option value="enseignant">Enseignant</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" id="searchLabel">Rechercher par Massar</label>
                        <div class="d-flex gap-2">
                            <input type="text" id="searchQ" class="form-control" placeholder="Code Massar...">
                            <button type="button" class="btn-primary-app" onclick="doSearch()">🔍</button>
                        </div>
                    </div>
                    <div id="searchResult"></div>
                    <input type="hidden" name="personne_id" id="personne_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-primary-app">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateLabel() {
    const role = document.getElementById('roleSelect').value;
    document.getElementById('searchLabel').textContent = role === 'etudiant' ? 'Rechercher par Massar' : 'Rechercher par CIN';
    document.getElementById('searchQ').placeholder = role === 'etudiant' ? 'Code Massar...' : 'Code CIN...';
}

async function doSearch() {
    const role = document.getElementById('roleSelect').value;
    const q    = document.getElementById('searchQ').value.trim();
    if (!q) return;

    const res  = await fetch(`{{ route('admin.comptes.search') }}?role=${role}&q=${encodeURIComponent(q)}`, {
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
    });
    const data = await res.json();
    const div  = document.getElementById('searchResult');

    if (data.error) {
        div.innerHTML = `<div class="alert alert-danger py-2">${data.error}</div>`;
        document.getElementById('personne_id').value = '';
    } else {
        div.innerHTML = `
            <div class="p-3 rounded" style="background:#f0fdf4;border:1px solid #bbf7d0">
                <strong>${data.prenom_fr} ${data.nom_fr}</strong><br>
                <small class="text-muted">${data.email || ''}</small>
            </div>`;
        document.getElementById('personne_id').value = data.id;
    }
}
</script>
@endpush

@endsection
