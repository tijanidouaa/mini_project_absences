<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $table = 'elements';

    protected $fillable = [
        'titre',
        'module_id',
    ];

    // Un élément appartient à un module
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    // Un élément a plusieurs absences
    public function absences()
    {
        return $this->hasMany(Absence::class, 'element_id');
    }
}