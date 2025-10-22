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
    ];
    
    public function naves()
    {
        return $this->belongsToMany(Nave::class, 'nave_piloto', 'piloto_id', 'nave_id')
                    ->withPivot('fecha_inicio_asociacion', 'fecha_fin_asociacion')
                    ->withTimestamps();
    }
}
