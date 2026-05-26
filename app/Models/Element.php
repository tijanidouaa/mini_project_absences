<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Element extends Model {
    protected $table = 'elements';
    protected $fillable = ['titre','module_id'];

    public function module() { return $this->belongsTo(ModulePeda::class, 'module_id'); }
}
