<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    protected $table = 'enseignants';

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

    // Lien vers le compte utilisateur
    public function compte()
    {
        return $this->hasOne(Utilisateur::class, 'personne_id')->where('role', 'enseignant');
    }

    // Accessor : nom complet
    public function getNomCompletAttribute(): string
    {
        return $this->prenom_fr . ' ' . $this->nom_fr;
    }
}
