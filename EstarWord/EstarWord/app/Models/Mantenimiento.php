<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'mantenimientos';

    protected $fillable = ['nave_id', 'fecha', 'descripcion', 'coste'];

    use HasFactory;

    // Un mantenimiento pertenece a una nave
    public function nave()
    {
        return $this->belongsTo(Nave::class, 'nave_id');
    }

    public function calcularCosto(Carbon $fecha_inicio, Carbon $fecha_fin, int $coste_por_dia = 100)
    {
        // diffInDays calcula los días completos transcurridos.
        $dias = $fecha_inicio->diffInDays($fecha_fin);

        return $dias * $coste_por_dia;
    }
}

