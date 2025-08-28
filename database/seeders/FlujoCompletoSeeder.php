<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Auditor;
use App\Models\Representante;
use App\Models\Tarea;
use App\Models\TareaCampo;
use App\Models\TareaCliente;
use App\Models\TareaInstancia;
use App\Models\TareaInstanciaValor;
use App\Models\Notificacion;
use Carbon\Carbon;

class FlujoCompletoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cliente
        $cliente = Cliente::create([
            'razon_social' => 'ACME S.A. de C.V.',
            'nit' => '0614-260999-101-0',
            'nrc' => '123456-7',
        ]);

        // 2. Auditor
        $auditor = Auditor::create([
            'nombre' => 'Carlos Méndez',
            'telefono' => '7777-1234',
            'correo_electronico' => 'carlos.mendez@auditores.com',
            'empresa' => 'Méndez & Asociados',
            'num_vpcpa' => 'VPCPA-2025-01',
            'nombrado' => true,
        ]);
        $cliente->auditores()->attach($auditor->id);

        // 3. Representante
        $representante = Representante::create([
            'nombre' => 'María López',
            'dui' => '01234567-8',
            'fecha_nombramiento' => Carbon::now()->subMonths(6),
            'duracion_meses' => 12,
            'numero_acta' => 'ACTA-2025-01',
            'numero_acuerdo' => 'ACUERDO-2025-01',
        ]);
        $cliente->representantes()->attach($representante->id);

        // 4. Tarea
        $tarea = Tarea::create([
            'nombre' => 'Declaración de IVA',
            'descripcion' => 'Declaración mensual de IVA ante Hacienda',
        ]);

        // Campos de la tarea
        $campoVentas = TareaCampo::create([
            'tarea_id' => $tarea->id,
            'nombre' => 'ventas',
            'etiqueta' => 'Ventas del período',
            'tipo' => 'numerico',
            'obligatorio' => true,
        ]);

        $campoCompras = TareaCampo::create([
            'tarea_id' => $tarea->id,
            'nombre' => 'compras',
            'etiqueta' => 'Compras del período',
            'tipo' => 'numerico',
            'obligatorio' => true,
        ]);

        // 5. Asignar tarea al cliente
        $tareaCliente = TareaCliente::create([
            'tarea_id' => $tarea->id,
            'cliente_id' => $cliente->id,
            'contador_id' => null, // se puede asignar después a un usuario
            'auditor_id' => $auditor->id,
            'representante_id' => $representante->id,
            'alerta_dias_antes' => 3,
            'activo' => true,
        ]);

        // 6. Instancia de tarea
        $instancia = TareaInstancia::create([
            'tarea_id' => $tarea->id,
            'tarea_cliente_id' => $tareaCliente->id,
            'cliente_id' => $cliente->id,
            'auditor_id' => $auditor->id,
            'representante_id' => $representante->id,
            'estado' => 'PENDIENTE',
            'fecha_vencimiento' => Carbon::now()->addDays(5),
            'notas' => 'Declarar IVA de agosto 2025',
        ]);

        // 7. Valores de la instancia
        TareaInstanciaValor::create([
            'instancia_id' => $instancia->id,
            'campo_id' => $campoVentas->id,
            'valor_num' => 1500.00,
        ]);

        TareaInstanciaValor::create([
            'instancia_id' => $instancia->id,
            'campo_id' => $campoCompras->id,
            'valor_num' => 800.00,
        ]);

        // 8. Notificación
        Notificacion::create([
            'instancia_id' => $instancia->id,
            'tipo' => 'recordatorio',
            'destinatario' => 'contador@acme.com',
            'umbral_days_before' => 3,
            'enviado' => false,
            'payload' => [
                'mensaje' => 'Recordatorio: Declaración IVA vence en 3 días.',
            ],
        ]);
    }
}
