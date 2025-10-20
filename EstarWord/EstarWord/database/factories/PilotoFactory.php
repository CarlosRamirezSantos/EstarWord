<?php
namespace Database\Factories;

use App\Models\Piloto;
use Illuminate\Database\Eloquent\Factories\Factory;

class PilotoFactory extends Factory
{
    protected $model = Piloto::class;

    public function definition()
    {
            $faker = \Faker\Factory::create('es_ES');

        return [
            'nombre' => $faker->name(),
            'altura' => rand(150, 220),
            'ano_nacimiento' => $faker->year($max = '2000'),
            'genero' => $faker->randomElement(['Masculino', 'Femenino', 'Otro']),
        ];
    }
}
