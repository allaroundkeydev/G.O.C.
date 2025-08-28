<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Auditor;
use App\Models\Representante;
use Illuminate\Database\Seeder;

class ClienteRelacionesSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();
        $auditores = Auditor::all();
        $representantes = Representante::all();

        foreach ($clientes as $cliente) {
            // Asignar 1 auditor aleatorio
            if ($auditores->count() > 0) {
                $auditor = $auditores->random();
                $cliente->auditores()->syncWithoutDetaching([$auditor->id]);
            }

            // Asignar 1 representante aleatorio
            if ($representantes->count() > 0) {
                $rep = $representantes->random();
                $cliente->representantes()->syncWithoutDetaching([$rep->id]);
            }
        }
    }
}
