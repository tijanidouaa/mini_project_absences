@extends('layouts.app')
@section('title', 'Structure Pédagogique — Modules')

@section('content')
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('admin.structure.filieres') }}" class="btn-primary-app" style="background:#6b7280">🏫 Filières</a>
    <a href="{{ route('admin.structure.niveaux') }}"  class="btn-primary-app" style="background:#6b7280">📚 Niveaux</a>
    <a href="{{ route('admin.structure.modules') }}"  class="btn-primary-app">📦 Modules</a>
    <a href="{{ route('admin.structure.elements') }}" class="btn-primary-app" style="background:#6b7280">📄 Éléments</a>
    <a href="{{ route('admin.structure.import') }}"   class="btn-primary-app" style="background:#059669">⬆ Import CSV</a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="form-card">
            <h2 style="font-size:1rem;font-weight:700;color:#0f1e3d;margin-bottom:18px">➕ Nouveau module</h2>
            <form method="POST" action="{{ route('admin.structure.modules.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="titre" class="form-control" placeholder="ex: Algorithmique" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Code *</label>
                    <input type="text" name="code" class="form-control" placeholder="ex: ASD101" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Niveau *</label>
                    <select name="niveau_id" class="form-select" required>
                        <option value="">— Choisir —</option>
                        @foreach($niveaux as $n)
                            <option value="{{ $n->id }}">{{ $n->filiere->alias }} — {{ $n->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary-app w-100">Ajouter</button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="table-card">
            <div class="table-card-header"><h2>Modules pédagogiques ({{ $modules->count() }})</h2></div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Titre</th><th>Code</th><th>Niveau</th><th>Éléments</th><th>Actions</th></tr></thead>
                    <tbody>
                    @forelse($modules as $m)
                        <tr>
                            <td><strong>{{ $m->titre }}</strong></td>
                            <td><code>{{ $m->code }}</code></td>
                            <td style="font-size:.82rem">{{ $m->niveau->filiere->alias }} — {{ $m->niveau->libelle }}</td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $m->elements->count() }} élément(s)</span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-sm-edit" onclick="openEditModule({{ $m->toJson() }})">✏</button>
                                    <form method="POST" action="{{ route('admin.structure.modules.destroy', $m) }}"
                                        onsubmit="return confirm('Supprimer ce module et ses éléments ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-sm-danger">🗑</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">Aucun module.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal edit module --}}
<div class="modal fade" id="modalEditModule" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">✏ Modifier le module</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="formEditModule">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Titre *</label>
                        <input type="text" name="titre" id="em_titre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Code *</label>
                        <input type="text" name="code" id="em_code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Niveau *</label>
                        <select name="niveau_id" id="em_niveau" class="form-select" required>
                            @foreach($niveaux as $n)
                                <option value="{{ $n->id }}">{{ $n->filiere->alias }} — {{ $n->libelle }}</option>
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
function openEditModule(m) {
    document.getElementById('em_titre').value  = m.titre;
    document.getElementById('em_code').value   = m.code;
    document.getElementById('em_niveau').value = m.niveau_id;
    document.getElementById('formEditModule').action = `/admin/structure/modules/${m.id}`;
    new bootstrap.Modal(document.getElementById('modalEditModule')).show();
}
</script>
@endpush
@endsection
