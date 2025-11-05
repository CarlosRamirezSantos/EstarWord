<?php

namespace App\Services;

use Carbon\Carbon;

class MantenimientoService
{
    /**
     * Calcula el costo de un mantenimiento basado en los días.
     *
     * @param Carbon $fecha_inicio
     * @param Carbon $fecha_fin
     * @param int $coste_por_dia
     * @return float|int
     */
    public function calcularCosto(Carbon $fecha_inicio, Carbon $fecha_fin, int $coste_por_dia = 100)
    {
        // diffInDays calcula los días completos transcurridos.
        // Ej: '2024-01-01' a '2024-01-03' -> 2 días.
        $dias = $fecha_inicio->diffInDays($fecha_fin);

        return $dias * $coste_por_dia;
    }
}