<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nave;
use App\Models\Planeta;

class NaveSeeder extends Seeder
{
    public function run()
    {
        // Crear naves para cada planeta existente
        Planeta::all()->each(function ($planeta) {
            Nave::factory()->count(3)->create(['planeta_id' => $planeta->id]);
        });
    }
}
