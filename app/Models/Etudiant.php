<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etudiant extends Model
{
    use SoftDeletes;

    protected $table = 'etudiants';

    protected $fillable = [
        'nom_fr', 'prenom_fr', 'nom_ar', 'prenom_ar',
        'massar', 'cin', 'email', 'niveau_id',
        'cursus', 'telephone', 'date_naissance', 'photo',
    ];

    protected $casts = ['date_naissance' => 'date'];

    public function niveau() {
        return $this->belongsTo(Niveau::class, 'niveau_id');
    }
    public function absences() {
        return $this->hasMany(Absence::class, 'etudiant_id');
    }
    public function reclamations() {
        return $this->hasMany(Reclamation::class, 'etudiant_id');
    }
    public function demandesPermission() {
        return $this->hasMany(DemandePermission::class, 'etudiant_id');
    }
    public function compte() {
        return $this->hasOne(Utilisateur::class, 'personne_id')->where('role', 'etudiant');
    }
    public function historique() {
        return $this->hasMany(HistoriqueModification::class, 'etudiant_id');
    }
    public function getNomCompletAttribute(): string {
        return $this->prenom_fr . ' ' . $this->nom_fr;
    }
    public function getNomCompletArAttribute(): string {
        return ($this->prenom_ar ?? '') . ' ' . ($this->nom_ar ?? '');
    }
}