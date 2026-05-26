<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    // Nom de la table dans la BDD
    protected $table = 'enseignants';

    // Colonnes que l'on peut remplir
    protected $fillable = [
        'nom_fr',
        'prenom_fr',
        'nom_ar',
        'prenom_ar',
        'cin',
        'email',
        'telephone',
    ];

    // Un enseignant peut avoir plusieurs absences marquées
    public function absences()
    {
        return $this->hasMany(Absence::class, 'enseignant_id');
    }

    // Un enseignant peut avoir plusieurs demandes de permission
    public function demandesPermission()
    {
        return $this->hasMany(DemandePermission::class, 'enseignant_id');
    }

    // Un enseignant peut coordonner plusieurs filières
    public function filieres()
    {
        return $this->hasMany(Filiere::class, 'coordonnateur_id');
    }
}