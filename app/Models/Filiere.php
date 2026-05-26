<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model {
    protected $table = 'filieres';
    protected $fillable = ['alias','intitule','annee_accreditation','annee_fin_accreditation','coordonnateur_id'];

    public function niveaux()       { return $this->hasMany(Niveau::class, 'filiere_id'); }
    public function coordonnateur() { return $this->belongsTo(Enseignant::class, 'coordonnateur_id'); }
}
