<?php

// Seeder para tabla pivote piloto_nave
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Piloto;
use App\Models\Nave;

class PilotoNaveSeeder extends Seeder
{
    public function run()
    {
        $pilotos = Piloto::all();
        $naves = Nave::all();

        foreach ($naves as $nave) {
            // Asignar aleatoriamente pilotos a la nave con fechas
            $pilotosAsignados = $pilotos->random(rand(0, 3));

            foreach ($pilotosAsignados as $piloto) {
                $nave->pilotos()->attach($piloto->id, [
                    'fecha_inicio' => now()->subMonths(rand(1, 24)),
                    'fecha_fin' => rand(0, 1) ? now() : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
