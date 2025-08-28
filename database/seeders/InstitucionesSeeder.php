<?php

namespace Database\Seeders;

use App\Models\Institucion;
use Illuminate\Database\Seeder;

class InstitucionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instituciones = [
            [
                'nombre' => 'Alcaldía',
                'descripcion' => 'Municipalidad local',
            ],
            [
                'nombre' => 'Ministerio de Trabajo',
                'descripcion' => 'Ministerio encargado de asuntos laborales',
            ],
            [
                'nombre' => 'UIF',
                'descripcion' => 'Unidad de Inteligencia Financiera',
            ],
            [
                'nombre' => 'Hacienda',
                'descripcion' => 'Ministerio de Hacienda',
            ],
        ];

        foreach ($instituciones as $institucion) {
            Institucion::firstOrCreate(
                ['nombre' => $institucion['nombre']],
                $institucion
            );
        }
    }
}