<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'login',
        'password',
        'role',
        'personne_id',
        'enabled',
        'locked',
        'tentatives',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'locked'  => 'boolean',
    ];

    // Utiliser 'login' comme identifiant d'authentification
    public function getAuthIdentifierName(): string
    {
        return 'login';
    }

    // Relation vers l'étudiant lié
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'personne_id');
    }

    // Relation vers l'enseignant lié
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'personne_id');
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

    // Helpers rôles
    public function isAdmin(): bool
    {
        return $this->role === 'administrateur';
    }

    public function isEnseignant(): bool
    {
        return $this->role === 'enseignant';
    }

    public function isEtudiant(): bool
    {
        return $this->role === 'etudiant';
    }

    // Accessor : nom complet selon le rôle
    public function getNomCompletAttribute(): string
    {
        return match ($this->role) {
            'etudiant'   => optional($this->etudiant)->prenom_fr . ' ' . optional($this->etudiant)->nom_fr,
            'enseignant' => optional($this->enseignant)->prenom_fr . ' ' . optional($this->enseignant)->nom_fr,
            default      => $this->login,
        };
    }
}
