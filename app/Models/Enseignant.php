<?php
// ===== Enseignant.php =====
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model {
    protected $table = 'enseignants';
    protected $fillable = ['nom_fr','prenom_fr','nom_ar','prenom_ar','cin','email','telephone'];

    public function filieres() { return $this->hasMany(Filiere::class, 'coordonnateur_id'); }
    public function compte()   { return $this->hasOne(Utilisateur::class,'personne_id')->where('role','enseignant'); }
    public function getNomCompletAttribute(): string { return $this->prenom_fr.' '.$this->nom_fr; }
}
