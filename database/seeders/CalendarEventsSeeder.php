<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CalendarEvent;

class CalendarEventsSeeder extends Seeder
{
    public function run()
    {
        CalendarEvent::factory(20)->create();
    }
}
