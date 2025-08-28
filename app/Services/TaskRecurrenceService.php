<?php

namespace App\Services;

use App\Models\TareaCliente;
use App\Models\TareaInstancia;
use Illuminate\Support\Facades\Log;

class TaskRecurrenceService
{
    /**
     * Generate task instances based on recurrence rules.
     *
     * @param TareaCliente $tareaCliente
     * @param int $daysAhead Number of days to generate instances for
     */
    public function generateInstances(TareaCliente $tareaCliente, int $daysAhead = 30): void
    {
        if (!$tareaCliente->recurrence_rule || !$tareaCliente->activo) {
            return;
        }

        try {
            // Parse the recurrence rule (simplified implementation)
            $recurrenceDates = $this->parseRecurrenceRule(
                $tareaCliente->recurrence_rule, 
                $daysAhead
            );

            foreach ($recurrenceDates as $date) {
                // Check if instance already exists for this date
                $existingInstance = TareaInstancia::where('tarea_cliente_id', $tareaCliente->id)
                    ->whereDate('fecha_vencimiento', $date)
                    ->first();

                if (!$existingInstance) {
                    // Create new instance
                    TareaInstancia::create([
                        'tarea_id' => $tareaCliente->tarea_id,
                        'tarea_cliente_id' => $tareaCliente->id,
                        'cliente_id' => $tareaCliente->cliente_id,
                        'contador_id' => $tareaCliente->contador_id,
                        'auditor_id' => $tareaCliente->auditor_id,
                        'representante_id' => $tareaCliente->representante_id,
                        'institucion_id' => $tareaCliente->institucion_id,
                        'estado' => 'PENDIENTE',
                        'fecha_vencimiento' => $date,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error generating instances for tarea cliente ID ' . $tareaCliente->id . ': ' . $e->getMessage());
        }
    }

    /**
     * Parse recurrence rule and generate dates.
     *
     * @param string $recurrenceRule
     * @param int $daysAhead
     * @return array
     */
    private function parseRecurrenceRule(string $recurrenceRule, int $daysAhead): array
    {
        $dates = [];
        $startDate = now();
        $endDate = now()->addDays($daysAhead);

        // This is a simplified implementation
        // In a real application, you would use a proper RRULE parser

        // Check if it's a simple daily, weekly, monthly rule
        if (strpos($recurrenceRule, 'FREQ=DAILY') !== false) {
            // Generate daily dates
            for ($i = 0; $i < $daysAhead; $i++) {
                $dates[] = $startDate->copy()->addDays($i);
            }
        } elseif (strpos($recurrenceRule, 'FREQ=WEEKLY') !== false) {
            // Generate weekly dates
            for ($i = 0; $i < 4; $i++) { // 4 weeks ahead
                $dates[] = $startDate->copy()->addWeeks($i);
            }
        } elseif (strpos($recurrenceRule, 'FREQ=MONTHLY') !== false) {
            // Generate monthly dates
            for ($i = 0; $i < 3; $i++) { // 3 months ahead
                $dates[] = $startDate->copy()->addMonths($i);
            }
        } else {
            // Default to single date
            $dates[] = $startDate;
        }

        return $dates;
    }

    /**
     * Generate renewal instances for representantes with upcoming expiration dates.
     *
     * @param int $daysAhead Number of days to check for expirations
     */
    public function generateRenewalInstances(int $daysAhead = 30): void
    {
        // Get representantes with fecha_fin_nombramiento in the specified range
        $representantes = \App\Models\Representante::whereNotNull('fecha_fin_nombramiento')
            ->whereBetween('fecha_fin_nombramiento', [now(), now()->addDays($daysAhead)])
            ->with(['cliente', 'cliente.tareasClientes.tarea'])
            ->get();

        foreach ($representantes as $representante) {
            try {
                $this->createRenewalInstance($representante);
            } catch (\Exception $e) {
                Log::error('Error creating renewal instance for representante ID ' . $representante->id . ': ' . $e->getMessage());
            }
        }
    }

    /**
     * Create a renewal instance for a representante.
     *
     * @param \App\Models\Representante $representante
     */
    private function createRenewalInstance($representante): void
    {
        // Find or create a renewal tarea
        $renewalTarea = \App\Models\Tarea::firstOrCreate(
            ['nombre' => 'Renovación de Nombramiento'],
            [
                'descripcion' => 'Renovar el nombramiento del representante legal',
                'created_by' => 1, // Admin user
            ]
        );

        // Check if there's already a tarea cliente for this combination
        $tareaCliente = \App\Models\TareaCliente::firstOrCreate(
            [
                'tarea_id' => $renewalTarea->id,
                'cliente_id' => $representante->cliente_id,
            ],
            [
                'representante_id' => $representante->id,
                'activo' => true,
                'alerta_dias_antes' => 7,
            ]
        );

        // Create the instance
        \App\Models\TareaInstancia::firstOrCreate(
            [
                'tarea_id' => $renewalTarea->id,
                'tarea_cliente_id' => $tareaCliente->id,
                'cliente_id' => $representante->cliente_id,
                'representante_id' => $representante->id,
                'fecha_vencimiento' => $representante->fecha_fin_nombramiento,
            ],
            [
                'estado' => 'PENDIENTE',
            ]
        );
    }
}