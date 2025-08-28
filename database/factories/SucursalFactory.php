<?php
namespace Database\Factories;

use App\Models\Sucursal;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class SucursalFactory extends Factory
{
    protected $model = Sucursal::class;

    public function definition()
    {
        return [
            'cliente_id' => Cliente::inRandomOrder()->first()?->id ?? null,
            'referencia' => $this->faker->bothify('SUC-###'),
            'direccion' => $this->faker->address,
            'telefono' => $this->faker->phoneNumber,
            'codigo_hacienda' => $this->faker->optional()->bothify('HC-####'),
        ];
    }
}
