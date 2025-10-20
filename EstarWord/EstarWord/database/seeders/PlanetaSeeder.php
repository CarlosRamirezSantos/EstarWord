<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Planeta;

class PlanetaSeeder extends Seeder
{
    public function run()
    {
        Planeta::factory()->count(5)->create();
    }
}
