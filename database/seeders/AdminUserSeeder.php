<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'nombre_completo' => 'Administrador del Sistema',
                'password' => Hash::make('password'),
                'email' => 'admin@example.com',
                'rol' => 'admin',
                'estado' => 'ACTIVO',
            ]
        );
    }
}