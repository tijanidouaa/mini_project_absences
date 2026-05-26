<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    protected $table = 'niveaux';

    protected $fillable = [
        'filiere_id',
        'libelle',
    ];

    // Un niveau appartient à une filière
    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'filiere_id');
    }

    // Un niveau a plusieurs étudiants
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'niveau_id');
    }

    // Un niveau a plusieurs modules
    public function modules()
    {
        return $this->hasMany(Module::class, 'niveau_id');
    }
}