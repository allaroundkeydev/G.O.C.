<?php

namespace App\Jobs;

use App\Models\TareaCliente;
use App\Models\TareaInstancia;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateTaskInstancesJob implements ShouldQueue
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
        Log::info('Starting GenerateTaskInstancesJob');

        // Get all active tarea clientes with recurrence rules
        $tareaClientes = TareaCliente::where('activo', true)
            ->whereNotNull('recurrence_rule')
            ->with(['tarea', 'cliente'])
            ->get();

        foreach ($tareaClientes as $tareaCliente) {
            try {
                $this->generateInstancesForTareaCliente($tareaCliente);
            } catch (\Exception $e) {
                Log::error('Error generating instances for tarea cliente ID ' . $tareaCliente->id . ': ' . $e->getMessage());
            }
        }

        Log::info('Finished GenerateTaskInstancesJob');
    }

    /**
     * Generate instances for a specific tarea cliente based on its recurrence rule.
     *
     * @param TareaCliente $tareaCliente
     */
    private function generateInstancesForTareaCliente(TareaCliente $tareaCliente): void
    {
        // For simplicity, we'll create instances for the next 30 days
        // In a real implementation, you would parse the RRULE and generate instances accordingly
        $startDate = now();
        $endDate = now()->addDays(30);

        // Check if instances already exist for this period to avoid duplicates
        $existingInstances = TareaInstancia::where('tarea_cliente_id', $tareaCliente->id)
            ->whereBetween('fecha_vencimiento', [$startDate, $endDate])
            ->count();

        // If no instances exist, create one for demonstration purposes
        // In a real implementation, you would parse the RRULE properly
        if ($existingInstances === 0) {
            TareaInstancia::create([
                'tarea_id' => $tareaCliente->tarea_id,
                'tarea_cliente_id' => $tareaCliente->id,
                'cliente_id' => $tareaCliente->cliente_id,
                'contador_id' => $tareaCliente->contador_id,
                'auditor_id' => $tareaCliente->auditor_id,
                'representante_id' => $tareaCliente->representante_id,
                'estado' => 'PENDIENTE',
                'fecha_vencimiento' => $startDate->addDays(7), // Due in 7 days
            ]);
            
            Log::info('Created instance for tarea cliente ID ' . $tareaCliente->id);
        }
    }
}