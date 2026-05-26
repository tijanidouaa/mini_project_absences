@extends('layouts.app')
@section('title', 'Structure Pédagogique — Éléments')

@section('content')
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('admin.structure.filieres') }}" class="btn-primary-app" style="background:#6b7280">🏫 Filières</a>
    <a href="{{ route('admin.structure.niveaux') }}"  class="btn-primary-app" style="background:#6b7280">📚 Niveaux</a>
    <a href="{{ route('admin.structure.modules') }}"  class="btn-primary-app" style="background:#6b7280">📦 Modules</a>
    <a href="{{ route('admin.structure.elements') }}" class="btn-primary-app">📄 Éléments</a>
    <a href="{{ route('admin.structure.import') }}"   class="btn-primary-app" style="background:#059669">⬆ Import CSV</a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="form-card">
            <h2 style="font-size:1rem;font-weight:700;color:#0f1e3d;margin-bottom:18px">➕ Nouvel élément</h2>
            <form method="POST" action="{{ route('admin.structure.elements.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="titre" class="form-control" placeholder="ex: Algorithmique" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Module *</label>
                    <select name="module_id" class="form-select" required>
                        <option value="">— Choisir —</option>
                        @foreach($modules as $m)
                            <option value="{{ $m->id }}">[{{ $m->code }}] {{ $m->titre }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary-app w-100">Ajouter</button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="table-card">
            <div class="table-card-header"><h2>Éléments / Matières ({{ $elements->count() }})</h2></div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Titre</th><th>Module</th><th>Niveau</th><th>Filière</th><th>Actions</th></tr></thead>
                    <tbody>
                    @forelse($elements as $el)
                        <tr>
                            <td><strong>{{ $el->titre }}</strong></td>
                            <td style="font-size:.82rem"><code>{{ $el->module->code }}</code> {{ $el->module->titre }}</td>
                            <td style="font-size:.78rem;color:#6b7a99">{{ $el->module->niveau->libelle }}</td>
                            <td><span class="badge-role badge-enseignant">{{ $el->module->niveau->filiere->alias }}</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-sm-edit" onclick="openEditElement({{ $el->toJson() }})">✏</button>
                                    <form method="POST" action="{{ route('admin.structure.elements.destroy', $el) }}"
                                        onsubmit="return confirm('Supprimer cet élément ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-sm-danger">🗑</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">Aucun élément.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal edit élément --}}
<div class="modal fade" id="modalEditElement" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">✏ Modifier l'élément</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="formEditElement">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Titre *</label>
                        <input type="text" name="titre" id="ee_titre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Module *</label>
                        <select name="module_id" id="ee_module" class="form-select" required>
                            @foreach($modules as $m)
                                <option value="{{ $m->id }}">[{{ $m->code }}] {{ $m->titre }}</option>
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
function openEditElement(el) {
    document.getElementById('ee_titre').value  = el.titre;
    document.getElementById('ee_module').value = el.module_id;
    document.getElementById('formEditElement').action = `/admin/structure/elements/${el.id}`;
    new bootstrap.Modal(document.getElementById('modalEditElement')).show();
}
</script>
@endpush
@endsection
