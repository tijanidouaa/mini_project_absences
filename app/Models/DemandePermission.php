<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandePermission extends Model
{
    protected $table = 'demandes_permission';

    protected $fillable = [
        'etudiant_id',
        'enseignant_id',
        'message',
        'reponse',
        'etat',
    ];

    // Une demande appartient à un étudiant
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }

    // Une demande appartient à un enseignant
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }
}