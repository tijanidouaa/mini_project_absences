<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    protected $table = 'reclamations';

    protected $fillable = [
        'absence_id',
        'etudiant_id',
        'message',
        'reponse',
        'etat',
    ];

    // Une réclamation appartient à une absence
    public function absence()
    {
        return $this->belongsTo(Absence::class, 'absence_id');
    }

    // Une réclamation appartient à un étudiant
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }
}