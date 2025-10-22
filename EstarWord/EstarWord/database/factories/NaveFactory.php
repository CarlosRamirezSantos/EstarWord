<?php
namespace Database\Factories;

use App\Models\Planeta;
use App\Models\Nave;
use Illuminate\Database\Eloquent\Factories\Factory;

class NaveFactory extends Factory
{
    protected $model = Nave::class;

    public function definition()
    {

        $faker = \Faker\Factory::create('es_ES');
        return [
            'nombre' => $faker->word(),
            'modelo' => 'Modelo ' . rand(3, true),
            'tripulacion' => rand(1, 100),
            'pasajeros' => rand(1, 1000),
            'clase_nave' => $faker->randomElement(['Carguero', 'Combate', 'Transporte']),
            'planeta_id' => $faker->randomElement(Planeta::get('id')),
        ];
    }
}
