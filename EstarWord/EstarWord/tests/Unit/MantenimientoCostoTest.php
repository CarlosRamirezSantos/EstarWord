<?php

namespace Tests\Unit;

use App\Services\MantenimientoService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class MantenimientoCostoTest extends TestCase
{
    
   public function test_calcula_costo_de_mantenimiento()
    {
       
        $service = new MantenimientoService();
        $fecha_inicio = Carbon::parse('2024-01-01');
        $fecha_fin = Carbon::parse('2024-01-06'); 

    
        $costo_calculado = $service->calcularCosto($fecha_inicio, $fecha_fin, 100);

        $this->assertEquals(500, $costo_calculado);
    }
}
