<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueModification extends Model
{
    protected $table = 'historique_modifications';

    protected $fillable = [
        'etudiant_id',
        'utilisateur_id',
        'champ_modifie',
        'ancienne_valeur',
        'nouvelle_valeur',
        'date_modification',
    ];

    // Appartient à un étudiant
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }

    // Appartient à un utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
}