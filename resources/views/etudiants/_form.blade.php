<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nom (Français) *</label>
        <input type="text" name="nom_fr" class="form-control @error('nom_fr') is-invalid @enderror"
               value="{{ old('nom_fr', $etudiant->nom_fr ?? '') }}" required>
        @error('nom_fr')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Prénom (Français) *</label>
        <input type="text" name="prenom_fr" class="form-control @error('prenom_fr') is-invalid @enderror"
               value="{{ old('prenom_fr', $etudiant->prenom_fr ?? '') }}" required>
        @error('prenom_fr')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Nom (Arabe)</label>
        <input type="text" name="nom_ar" class="form-control" dir="rtl"
               value="{{ old('nom_ar', $etudiant->nom_ar ?? '') }}" placeholder="نادر">
    </div>
    <div class="col-md-6">
        <label class="form-label">Prénom (Arabe)</label>
        <input type="text" name="prenom_ar" class="form-control" dir="rtl"
               value="{{ old('prenom_ar', $etudiant->prenom_ar ?? '') }}" placeholder="محمد أنور">
    </div>
    <div class="col-md-6">
        <label class="form-label">Identifiant Massar *</label>
        <input type="text" name="massar" class="form-control @error('massar') is-invalid @enderror"
               value="{{ old('massar', $etudiant->massar ?? '') }}" required placeholder="G123456789">
        @error('massar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Code CIN</label>
        <input type="text" name="cin" class="form-control"
               value="{{ old('cin', $etudiant->cin ?? '') }}" placeholder="AB123456">
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $etudiant->email ?? '') }}" placeholder="etudiant@etu.uae.ac.ma">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Téléphone</label>
        <input type="text" name="telephone" class="form-control"
               value="{{ old('telephone', $etudiant->telephone ?? '') }}" placeholder="06XXXXXXXX">
    </div>
    <div class="col-md-6">
        <label class="form-label">Cursus</label>
        <input type="text" name="cursus" class="form-control"
               value="{{ old('cursus', $etudiant->cursus ?? '') }}" placeholder="Génie Informatique">
    </div>
    <div class="col-md-6">
        <label class="form-label">Date de naissance</label>
        <input type="date" name="date_naissance" class="form-control"
               value="{{ old('date_naissance', isset($etudiant) ? $etudiant->date_naissance?->format('Y-m-d') : '') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Niveau</label>
        <select name="niveau_id" class="form-select">
            <option value="">— Choisir un niveau —</option>
            @foreach($niveaux as $n)
                <option value="{{ $n->id }}"
                    {{ old('niveau_id', $etudiant->niveau_id ?? '') == $n->id ? 'selected' : '' }}>
                    {{ $n->filiere->alias }} — {{ $n->libelle }}
                </option>
            @endforeach
        </select>
    </div>
</div>
