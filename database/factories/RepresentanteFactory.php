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
            'fecha_nacimiento' => $this->faker->date(),
            'telefono' => $this->faker->phoneNumber(),
            'correo_electronico' => $this->faker->unique()->safeEmail(),
            'dui' => $this->faker->numerify('########-#'),
            'fecha_nombramiento' => $this->faker->date(),
            'duracion_meses' => $this->faker->numberBetween(12, 60),
            'fecha_fin_nombramiento' => $this->faker->date(),
            'numero_acta' => $this->faker->bothify('ACTA-####'),
            'numero_acuerdo' => $this->faker->bothify('ACU-####'),
        ];
    }
}
