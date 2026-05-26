@extends('layouts.app')
@section('title', 'Structure Pédagogique — Niveaux')

@section('content')
{{-- Navigation structure --}}
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('admin.structure.filieres') }}" class="btn-primary-app" style="background:#6b7280">🏫 Filières</a>
    <a href="{{ route('admin.structure.niveaux') }}"  class="btn-primary-app">📚 Niveaux</a>
    <a href="{{ route('admin.structure.modules') }}"  class="btn-primary-app" style="background:#6b7280">📦 Modules</a>
    <a href="{{ route('admin.structure.elements') }}" class="btn-primary-app" style="background:#6b7280">📄 Éléments</a>
    <a href="{{ route('admin.structure.import') }}"   class="btn-primary-app" style="background:#059669">⬆ Import CSV</a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="form-card">
            <h2 style="font-size:1rem;font-weight:700;color:#0f1e3d;margin-bottom:18px">➕ Nouveau niveau</h2>
            <form method="POST" action="{{ route('admin.structure.niveaux.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Filière *</label>
                    <select name="filiere_id" class="form-select" required>
                        <option value="">— Choisir —</option>
                        @foreach($filieres as $f)
                            <option value="{{ $f->id }}">{{ $f->alias }} — {{ $f->intitule }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Libellé *</label>
                    <input type="text" name="libelle" class="form-control" placeholder="ex: GI - Semestre 1" required>
                </div>
                <button type="submit" class="btn-primary-app w-100">Ajouter</button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="table-card">
            <div class="table-card-header"><h2>Niveaux ({{ $niveaux->count() }})</h2></div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Libellé</th><th>Filière</th><th>Étudiants</th><th>Actions</th></tr></thead>
                    <tbody>
                    @forelse($niveaux as $n)
                        <tr>
                            <td><strong>{{ $n->libelle }}</strong></td>
                            <td><span class="badge-role badge-enseignant">{{ $n->filiere->alias }}</span></td>
                            <td>{{ $n->etudiants->count() }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-sm-edit" onclick="openEditNiveau({{ $n->toJson() }})">✏</button>
                                    <form method="POST" action="{{ route('admin.structure.niveaux.destroy', $n) }}"
                                        onsubmit="return confirm('Supprimer ce niveau ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-sm-danger">🗑</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">Aucun niveau.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal edit niveau --}}
<div class="modal fade" id="modalEditNiveau" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">✏ Modifier le niveau</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="formEditNiveau">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Filière *</label>
                        <select name="filiere_id" id="en_filiere" class="form-select" required>
                            @foreach($filieres as $f)
                                <option value="{{ $f->id }}">{{ $f->alias }} — {{ $f->intitule }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Libellé *</label>
                        <input type="text" name="libelle" id="en_libelle" class="form-control" required>
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
function openEditNiveau(n) {
    document.getElementById('en_filiere').value = n.filiere_id;
    document.getElementById('en_libelle').value = n.libelle;
    document.getElementById('formEditNiveau').action = `/admin/structure/niveaux/${n.id}`;
    new bootstrap.Modal(document.getElementById('modalEditNiveau')).show();
}
</script>
@endpush
@endsection
