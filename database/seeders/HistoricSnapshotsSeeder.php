<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HistoricSnapshot;

class HistoricSnapshotsSeeder extends Seeder
{
    public function run()
    {
        HistoricSnapshot::factory(20)->create();
    }
}
