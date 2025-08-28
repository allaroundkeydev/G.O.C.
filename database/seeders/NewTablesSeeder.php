<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NewTablesSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            SucursalesSeeder::class,
            AttachmentsSeeder::class,
            SettingsSeeder::class,
            CalendarEventsSeeder::class,
            HistoricSnapshotsSeeder::class,
        ]);
    }
}
