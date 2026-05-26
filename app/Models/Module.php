<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

    protected $fillable = [
        'titre',
        'code',
        'niveau_id',
    ];

    // Un module appartient à un niveau
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'niveau_id');
    }

    // Un module a plusieurs éléments (matières)
    public function elements()
    {
        return $this->hasMany(Element::class, 'module_id');
    }
}