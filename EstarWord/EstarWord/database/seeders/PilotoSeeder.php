<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Piloto;

class PilotoSeeder extends Seeder
{
    public function run()
    {
        Piloto::factory()->count(10)->create();
    }
}

