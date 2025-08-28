<?php

namespace Database\Seeders;

use App\Models\Auditor;
use Illuminate\Database\Seeder;

class AuditorSeeder extends Seeder
{
    public function run(): void
    {
        Auditor::factory(5)->create();
    }
}
