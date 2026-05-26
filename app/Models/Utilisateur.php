<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $table = 'utilisateurs';

    protected $fillable = [
        'login',
        'password_hash',
        'role',
        'personne_id',
        'enabled',
        'locked',
        'tentatives',
    ];

    // Cacher le mot de passe dans les réponses
    protected $hidden = [
        'password_hash',
    ];

    // Un utilisateur a plusieurs notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'utilisateur_id');
    }

    // Un utilisateur a plusieurs logs de connexion
    public function logsConnexion()
    {
        return $this->hasMany(LogConnexion::class, 'utilisateur_id');
    }

    // Un utilisateur a plusieurs logs d'actions
    public function logsActions()
    {
        return $this->hasMany(LogAction::class, 'utilisateur_id');
    }
}