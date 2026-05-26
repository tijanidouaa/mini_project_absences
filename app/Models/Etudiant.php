<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etudiant extends Model
{
    use SoftDeletes; // permet le soft delete (récupération possible)

    protected $table = 'etudiants';

    protected $fillable = [
        'nom_fr',
        'prenom_fr',
        'nom_ar',
        'prenom_ar',
        'massar',
        'cin',
        'email',
        'niveau_id',
        'cursus',
        'telephone',
        'date_naissance',
        'photo',
    ];

    // Un étudiant appartient à un niveau
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'niveau_id');
    }

    // Un étudiant a plusieurs absences
    public function absences()
    {
        return $this->hasMany(Absence::class, 'etudiant_id');
    }

    // Un étudiant a plusieurs réclamations
    public function reclamations()
    {
        return $this->hasMany(Reclamation::class, 'etudiant_id');
    }

    // Un étudiant a plusieurs demandes de permission
    public function demandesPermission()
    {
        return $this->hasMany(DemandePermission::class, 'etudiant_id');
    }
}