@extends('layouts.app')
@section('title', 'Import Structure Pédagogique')

@section('content')
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('admin.structure.filieres') }}" class="btn-primary-app" style="background:#6b7280">🏫 Filières</a>
    <a href="{{ route('admin.structure.niveaux') }}"  class="btn-primary-app" style="background:#6b7280">📚 Niveaux</a>
    <a href="{{ route('admin.structure.modules') }}"  class="btn-primary-app" style="background:#6b7280">📦 Modules</a>
    <a href="{{ route('admin.structure.elements') }}" class="btn-primary-app" style="background:#6b7280">📄 Éléments</a>
    <a href="{{ route('admin.structure.import') }}"   class="btn-primary-app" style="background:#059669">⬆ Import CSV</a>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="form-card">
            <h2 style="font-size:1.1rem;font-weight:700;color:#0f1e3d;margin-bottom:6px">⬆ Importer la structure pédagogique</h2>
            <p style="color:#6b7a99;font-size:.85rem;margin-bottom:20px">
                Importe filières, niveaux, modules et éléments depuis un fichier CSV.
            </p>
            <form method="POST" action="{{ route('admin.structure.import.post') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Fichier CSV *</label>
                    <input type="file" name="fichier" class="form-control" accept=".csv,.txt" required>
                    <div style="margin-top:8px;color:#6b7a99;font-size:.78rem">Formats acceptés : .csv, .txt</div>
                </div>
                <button type="submit" class="btn-primary-app">⬆ Importer</button>
            </form>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-card">
            <h2 style="font-size:1rem;font-weight:700;color:#0f1e3d;margin-bottom:14px">📋 Format du fichier CSV</h2>
            <p style="color:#6b7a99;font-size:.82rem;margin-bottom:12px">
                Le fichier doit contenir une ligne d'en-tête et les colonnes suivantes dans l'ordre :
            </p>
            <div style="background:#f8fafc;border-radius:10px;padding:14px;font-family:monospace;font-size:.78rem;overflow-x:auto">
                filiere_alias, filiere_intitule, annee_acc, annee_fin, niveau_libelle, module_titre, module_code, element_titre
            </div>
            <div style="margin-top:14px">
                <p style="font-size:.82rem;font-weight:700;color:#0f1e3d;margin-bottom:8px">Exemple :</p>
                <div style="background:#f8fafc;border-radius:10px;padding:14px;font-family:monospace;font-size:.75rem;overflow-x:auto;line-height:1.8">
                    filiere_alias,filiere_intitule,annee_acc,annee_fin,niveau_libelle,module_titre,module_code,element_titre<br>
                    GI,Génie Informatique,2022,2027,GI-S1,Algorithmique,ASD101,Algorithmes<br>
                    GI,Génie Informatique,2022,2027,GI-S1,Algorithmique,ASD101,Structures de Données<br>
                    GI,Génie Informatique,2022,2027,GI-S1,Prog Web,PW101,HTML/CSS<br>
                    GI,Génie Informatique,2022,2027,GI-S1,Prog Web,PW101,JavaScript
                </div>
            </div>
            <div style="margin-top:14px;padding:12px;background:#fef3c7;border-radius:10px;font-size:.8rem;color:#92400e">
                ⚠️ Les doublons sont ignorés automatiquement (firstOrCreate). L'import est sécurisé en transaction.
            </div>
        </div>
    </div>
</div>
@endsection
