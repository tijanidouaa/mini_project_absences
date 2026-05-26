<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Justification extends Model
{
    protected $table = 'justifications';

    protected $fillable = [
        'absence_id',
        'fichier',
        'etat',
    ];

    // Une justification appartient à une absence
    public function absence()
    {
        return $this->belongsTo(Absence::class, 'absence_id');
    }
}