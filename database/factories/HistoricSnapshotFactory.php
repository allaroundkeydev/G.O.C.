<?php
namespace Database\Factories;

use App\Models\HistoricSnapshot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoricSnapshotFactory extends Factory
{
    protected $model = HistoricSnapshot::class;

    public function definition()
    {
        return [
            'entity' => $this->faker->randomElement(['tareas_instancias', 'clientes']),
            'entity_id' => $this->faker->numberBetween(1, 10),
            'snapshot' => ['data' => $this->faker->randomElement(['x','y','z']), 'meta' => ['seed' => true]],
            'created_by' => User::inRandomOrder()->first()?->id,
        ];
    }
}
