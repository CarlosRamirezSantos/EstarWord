<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PlanetaSeeder::class,
            NaveSeeder::class,
            PilotoSeeder::class,
            MantenimientoSeeder::class,
            PilotoNaveSeeder::class,
        ]);
    }
}
