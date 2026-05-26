<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model {
    protected $table = 'niveaux';
    protected $fillable = ['filiere_id','libelle'];

    public function filiere()   { return $this->belongsTo(Filiere::class, 'filiere_id'); }
    public function modules()   { return $this->hasMany(ModulePeda::class, 'niveau_id'); }
    public function etudiants() { return $this->hasMany(Etudiant::class, 'niveau_id'); }
}
