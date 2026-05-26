<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAction extends Model
{
    protected $table = 'logs_actions';

    protected $fillable = [
        'utilisateur_id',
        'page_visitee',
        'date_heure',
    ];

    // Appartient à un utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
}