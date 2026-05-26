<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $table = 'filieres';

    protected $fillable = [
        'alias',
        'intitule',
        'annee_accreditation',
        'annee_fin_accreditation',
        'coordonnateur_id',
    ];

    // Une filière appartient à un enseignant coordonnateur
    public function coordonnateur()
    {
        return $this->belongsTo(Enseignant::class, 'coordonnateur_id');
    }

    // Une filière a plusieurs niveaux
    public function niveaux()
    {
        return $this->hasMany(Niveau::class, 'filiere_id');
    }
}
