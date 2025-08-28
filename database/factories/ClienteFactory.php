<?php
namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition()
    {
        return [
            'razon_social' => $this->faker->company,
            'dui' => null,
            'nit' => $this->faker->bothify('####-######-###-#'),
            'nrc' => $this->faker->numerify('#######'),
            'fecha_constitucion' => $this->faker->date(),
            'fecha_inscripcion' => $this->faker->date(),
            'tipo_gobierno' => 'administrador_unico',
        ];
    }
}
