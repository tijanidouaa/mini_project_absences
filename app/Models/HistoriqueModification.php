<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HistoriqueModification extends Model {
    protected $table = 'historique_modifications';
    protected $fillable = ['etudiant_id','utilisateur_id','champ_modifie','ancienne_valeur','nouvelle_valeur'];

    public function etudiant()    { return $this->belongsTo(Etudiant::class, 'etudiant_id'); }
    public function utilisateur() { return $this->belongsTo(Utilisateur::class, 'utilisateur_id'); }
}
