<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sucursal;
use App\Models\Cliente;

class SucursalesSeeder extends Seeder
{
    public function run()
    {
        // Si no hay clientes, crear algunos básicos
        if (Cliente::count() === 0) {
            \App\Models\Cliente::factory(5)->create();
        }

        // Crear sucursales: 1-2 por cliente
        Cliente::all()->each(function ($cliente) {
            Sucursal::factory(rand(1,2))->create(['cliente_id' => $cliente->id]);
        });
    }
}
