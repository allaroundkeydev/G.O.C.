<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            InstitucionesSeeder::class,
            ClienteSeeder::class,
            AuditorSeeder::class,
            RepresentanteSeeder::class,
            ClienteRelacionesSeeder::class,
            NewTablesSeeder::class, // si quieres mantener lo que tenías
            FlujoCompletoSeeder::class,
        ]);
    }
}
