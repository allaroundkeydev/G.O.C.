<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin principal
        User::create([
            'nombre_completo' => 'Administrador General',
            'username' => 'admin',
            'password' => Hash::make('password123'),
            'telefono' => '7000-0000',
            'email' => 'admin@goc.com',
            'rol' => 'admin',
            'estado' => 'activo',
        ]);

        // Crear 10 contadores
        User::factory(10)->create([
            'rol' => 'contador',
            'estado' => 'activo',
        ]);
    }
}
