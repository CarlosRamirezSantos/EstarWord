<?php

// Seeder para tabla mantenimientos
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mantenimiento;
use App\Models\Nave;

class MantenimientoSeeder extends Seeder
{
    public function run()
    {
        // Crear mantenimientos para cada nave
        Nave::all()->each(function ($nave) {
            Mantenimiento::factory()->count(2)->create(['nave_id' => $nave->id]);
        });
    }
}
