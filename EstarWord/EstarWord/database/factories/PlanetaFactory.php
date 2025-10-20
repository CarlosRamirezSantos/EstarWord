<?php
namespace Database\Factories;

use App\Models\Planeta;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanetaFactory extends Factory
{
    protected $model = Planeta::class;

    
    public function definition()
    {

        $faker = \Faker\Factory::create('es_ES');
        return [
            'nombre' => $faker->name,
            'periodo_rotacion' => $faker->randomNumber(2, true),
            'poblacion' => rand(1000, 1000000000),
            'clima' => $faker->randomElement(['árido', 'templado', 'frío', 'humedo']),
        ];
    }
}
