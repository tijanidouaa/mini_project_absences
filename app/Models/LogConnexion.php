<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogConnexion extends Model
{
    protected $table = 'logs_connexion';

    protected $fillable = [
        'utilisateur_id',
        'adresse_ip',
        'date_heure',
    ];

    // Appartient à un utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
}
