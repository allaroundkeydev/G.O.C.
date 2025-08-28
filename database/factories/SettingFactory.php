<?php
namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition()
    {
        return [
            'key' => 'sample_' . $this->faker->unique()->word,
            'value' => json_encode(['test' => $this->faker->word]),
            'type' => 'json',
            'descripcion' => $this->faker->sentence,
            'updated_by' => null,
        ];
    }
}
