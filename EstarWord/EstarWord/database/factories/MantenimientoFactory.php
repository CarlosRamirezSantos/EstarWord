<?php
namespace Database\Factories;

use App\Models\Nave;
use app\Models\Mantenimiento;
use Illuminate\Database\Eloquent\Factories\Factory;

class MantenimientoFactory extends Factory
{
    protected $model = Mantenimiento::class;

    public function definition()
    {

        $faker = \Faker\Factory::create('es_ES');
        return [
            'nave_id' => $faker->randomElement(Nave::get('id')),
            'fecha' => $faker->dateTimeBetween('-2 years', 'now'),
            'descripcion' => $faker->sentence(),
            'coste' => $faker->randomFloat(2, 50, 5000),
        ];
    }
}
