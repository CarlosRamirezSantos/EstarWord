<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Piloto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'altura',
        'anio_nacimiento',
        'genero',
        'profile_photo'
    ];

    public function naves()
    {
        return $this->belongsToMany(
            Nave::class, 
            'piloto_nave', 
            'piloto_id', 
            'nave_id')
            ->withPivot('fecha_inicio', 'fecha_fin')
            ->withTimestamps();
    }
}
