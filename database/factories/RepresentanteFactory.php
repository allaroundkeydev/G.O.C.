<?php

namespace Database\Factories;

use App\Models\Representante;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepresentanteFactory extends Factory
{
    protected $model = Representante::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'fecha_nacimiento' => $this->faker->optional()->date(),
            'telefono' => $this->faker->optional()->phoneNumber(),
            'correo_electronico' => $this->faker->optional()->safeEmail(),
            'dui' => $this->faker->optional()->numerify('########-#'),
            // ya no generar fecha_nombramiento, duracion_meses, etc. aquí
        ];
    }
}