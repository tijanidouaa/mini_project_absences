<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $table = 'absences';

    protected $fillable = [
        'etudiant_id',
        'element_id',
        'type_seance',
        'date_heure',
        'etat',
        'enseignant_id',
        'annee_academique',
    ];

    // Une absence appartient à un étudiant
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }

    // Une absence appartient à un élément pédagogique
    public function element()
    {
        return $this->belongsTo(Element::class, 'element_id');
    }

    // Une absence appartient à un enseignant
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }

    // Une absence a une justification
    public function justification()
    {
        return $this->hasOne(Justification::class, 'absence_id');
    }

    // Une absence a plusieurs réclamations
    public function reclamations()
    {
        return $this->hasMany(Reclamation::class, 'absence_id');
    }
}