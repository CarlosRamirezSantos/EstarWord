<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nave extends Model
{
    protected $table = 'naves';

    protected $fillable = ['nombre', 'modelo', 'tripulacion', 'pasajeros', 'clase_nave', 'planeta_id'];

    // Una nave pertenece a un planeta
    public function planeta()
    {
        return $this->belongsTo(Planeta::class, 'planeta_id');
    }

    // Una nave tiene muchos mantenimientos
    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'nave_id');
    }
    use HasFactory;
    // Una nave tiene muchos pilotos (relación muchos a muchos con tabla pivote)
    public function pilotos()
    {
        return $this->belongsToMany(Piloto::class, 'piloto_nave', 'nave_id', 'piloto_id')
            ->withPivot('fecha_inicio', 'fecha_fin')
            ->withTimestamps();
    }
}
