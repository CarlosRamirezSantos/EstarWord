<?php
namespace Database\Factories;

use App\Models\Piloto;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PilotoFactory extends Factory
{
    protected $model = Piloto::class;

    use HasFactory;
    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'altura' => $this->faker->numberBetween(150, 220),
            'ano_nacimiento' => $this->faker->year($max = '2000'),
            'genero' => $this->faker->randomElement(['Masculino', 'Femenino', 'Otro']),
        ];
    }
}
