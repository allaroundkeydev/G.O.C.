<?php

namespace App\Jobs;

use App\Models\Representante;
use App\Models\Tarea;
use App\Models\TareaCliente;
use App\Models\TareaInstancia;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateFromRepresentanteNombramientosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting CreateFromRepresentanteNombramientosJob');

        // Get representantes with fecha_fin_nombramiento in the next 30 days
        $representantes = Representante::whereNotNull('fecha_fin_nombramiento')
            ->whereBetween('fecha_fin_nombramiento', [now(), now()->addDays(30)])
            ->with(['cliente', 'cliente.tareasClientes.tarea'])
            ->get();

        foreach ($representantes as $representante) {
            try {
                $this->createRenewalInstance($representante);
            } catch (\Exception $e) {
                Log::error('Error creating renewal instance for representante ID ' . $representante->id . ': ' . $e->getMessage());
            }
        }

        Log::info('Finished CreateFromRepresentanteNombramientosJob');
    }

    /**
     * Create a renewal instance for a representante.
     *
     * @param Representante $representante
     */
    private function createRenewalInstance(Representante $representante): void
    {
        // Find the renewal tarea (you might want to have a specific tarea for this)
        $renewalTarea = Tarea::where('nombre', 'like', '%renovaci%n%nombramiento%')
            ->orWhere('nombre', 'like', '%renovar%nombramiento%')
            ->first();

        if (!$renewalTarea) {
            // If no specific tarea exists, you might want to create a default one
            Log::warning('No renewal tarea found for representante ID ' . $representante->id);
            return;
        }

        // Check if there's already a tarea cliente for this combination
        $tareaCliente = TareaCliente::where('tarea_id', $renewalTarea->id)
            ->where('cliente_id', $representante->cliente_id)
            ->first();

        if (!$tareaCliente) {
            // Create tarea cliente if it doesn't exist
            $tareaCliente = TareaCliente::create([
                'tarea_id' => $renewalTarea->id,
                'cliente_id' => $representante->cliente_id,
                'representante_id' => $representante->id,
                'activo' => true,
                'alerta_dias_antes' => 7,
            ]);
        }

        // Create the instance
        TareaInstancia::create([
            'tarea_id' => $renewalTarea->id,
            'tarea_cliente_id' => $tareaCliente->id,
            'cliente_id' => $representante->cliente_id,
            'representante_id' => $representante->id,
            'estado' => 'PENDIENTE',
            'fecha_vencimiento' => $representante->fecha_fin_nombramiento,
        ]);

        Log::info('Created renewal instance for representante ID ' . $representante->id);
    }
}