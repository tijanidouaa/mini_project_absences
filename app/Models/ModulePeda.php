<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// Nommé ModulePeda pour éviter le conflit avec le mot réservé "Module"
class ModulePeda extends Model {
    protected $table = 'modules';
    protected $fillable = ['titre','code','niveau_id'];

    public function niveau()   { return $this->belongsTo(Niveau::class, 'niveau_id'); }
    public function elements() { return $this->hasMany(Element::class, 'module_id'); }
}
