<?php
namespace Database\Factories;

use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CalendarEventFactory extends Factory
{
    protected $model = CalendarEvent::class;

    public function definition()
    {
        $start = $this->faker->dateTimeBetween('-1 month', '+2 months');
        $end = (clone $start)->modify('+2 hours');
        return [
            'title' => $this->faker->sentence(3),
            'start_at' => $start,
            'end_at' => $end,
            'all_day' => false,
            'description' => $this->faker->optional()->sentence,
            'created_by' => User::inRandomOrder()->first()?->id,
        ];
    }
}
