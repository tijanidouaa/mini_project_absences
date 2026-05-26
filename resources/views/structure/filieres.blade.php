@extends('layouts.app')
@section('title', 'Structure Pédagogique — Filières')

@section('content')
{{-- Navigation structure --}}
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('admin.structure.filieres') }}" class="btn-primary-app {{ request()->routeIs('admin.structure.filieres') ? '' : '' }}" style="{{ request()->routeIs('admin.structure.filieres') ? '' : 'background:#6b7280' }}">🏫 Filières</a>
    <a href="{{ route('admin.structure.niveaux') }}"  class="btn-primary-app" style="background:#6b7280">📚 Niveaux</a>
    <a href="{{ route('admin.structure.modules') }}"  class="btn-primary-app" style="background:#6b7280">📦 Modules</a>
    <a href="{{ route('admin.structure.elements') }}" class="btn-primary-app" style="background:#6b7280">📄 Éléments</a>
    <a href="{{ route('admin.structure.import') }}"   class="btn-primary-app" style="background:#059669">⬆ Import CSV</a>
</div>

<div class="row g-4">
    {{-- Formulaire ajout --}}
    <div class="col-lg-4">
        <div class="form-card">
            <h2 style="font-size:1rem;font-weight:700;color:#0f1e3d;margin-bottom:18px">➕ Nouvelle filière</h2>
            <form method="POST" action="{{ route('admin.structure.filieres.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Alias *</label>
                    <input type="text" name="alias" class="form-control" placeholder="GI1" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Intitulé *</label>
                    <input type="text" name="intitule" class="form-control" placeholder="Génie Informatique" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Année d'accréditation *</label>
                    <input type="number" name="annee_accreditation" class="form-control" placeholder="2022" min="2000" max="2100" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Année fin accréditation *</label>
                    <input type="number" name="annee_fin_accreditation" class="form-control" placeholder="2027" min="2000" max="2100" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Coordonnateur</label>
                    <select name="coordonnateur_id" class="form-select">
                        <option value="">— Aucun —</option>
                        @foreach($enseignants as $ens)
                            <option value="{{ $ens->id }}">{{ $ens->nom_complet }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary-app w-100">Ajouter</button>
            </form>
        </div>
    </div>

    {{-- Liste des filières --}}
    <div class="col-lg-8">
        <div class="table-card">
            <div class="table-card-header"><h2>Filières ({{ $filieres->count() }})</h2></div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Alias</th><th>Intitulé</th><th>Accréditation</th><th>Coordonnateur</th><th>Niveaux</th><th>Actions</th></tr></thead>
                    <tbody>
                    @forelse($filieres as $f)
                        <tr>
                            <td><strong>{{ $f->alias }}</strong></td>
                            <td>{{ $f->intitule }}</td>
                            <td style="font-size:.8rem">{{ $f->annee_accreditation }} → {{ $f->annee_fin_accreditation }}</td>
                            <td style="font-size:.82rem">{{ $f->coordonnateur?->nom_complet ?? '—' }}</td>
                            <td><span class="badge bg-light text-dark">{{ $f->niveaux->count() }}</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-sm-edit" onclick="openEditFiliere({{ $f->toJson() }})">✏</button>
                                    <form method="POST" action="{{ route('admin.structure.filieres.destroy', $f) }}"
                                        onsubmit="return confirm('Supprimer cette filière et tous ses niveaux ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-sm-danger">🗑</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">Aucune filière.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal edit filière --}}
<div class="modal fade" id="modalEditFiliere" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">✏ Modifier la filière</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="formEditFiliere">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Alias</label>
                        <input type="text" name="alias" id="ef_alias" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Intitulé</label>
                        <input type="text" name="intitule" id="ef_intitule" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Accréditation</label>
                        <input type="number" name="annee_accreditation" id="ef_annee" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Fin accréditation</label>
                        <input type="number" name="annee_fin_accreditation" id="ef_fin" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Coordonnateur</label>
                        <select name="coordonnateur_id" id="ef_coord" class="form-select">
                            <option value="">— Aucun —</option>
                            @foreach($enseignants as $ens)
                                <option value="{{ $ens->id }}">{{ $ens->nom_complet }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-primary-app">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openEditFiliere(f) {
    document.getElementById('ef_alias').value   = f.alias;
    document.getElementById('ef_intitule').value = f.intitule;
    document.getElementById('ef_annee').value   = f.annee_accreditation;
    document.getElementById('ef_fin').value     = f.annee_fin_accreditation;
    document.getElementById('ef_coord').value   = f.coordonnateur_id || '';
    document.getElementById('formEditFiliere').action = `/admin/structure/filieres/${f.id}`;
    new bootstrap.Modal(document.getElementById('modalEditFiliere')).show();
}
</script>
@endpush
@endsection
