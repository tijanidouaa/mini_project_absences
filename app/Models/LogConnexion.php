<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LogConnexion extends Model {
    protected $table = 'logs_connexion';
    protected $fillable = ['utilisateur_id','adresse_ip'];
    public function utilisateur() { return $this->belongsTo(Utilisateur::class, 'utilisateur_id'); }
}
