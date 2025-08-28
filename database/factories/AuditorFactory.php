<?php
namespace Database\Factories;

use App\Models\Auditor;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditorFactory extends Factory
{
    protected $model = Auditor::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'telefono' => $this->faker->phoneNumber,
            'correo_electronico' => $this->faker->safeEmail,
            'empresa' => $this->faker->company,
            'num_vpcpa' => 'VPCPA-' . $this->faker->unique()->numerify('####'),
            'nombrado' => $this->faker->boolean(80),
        ];
    }
}
