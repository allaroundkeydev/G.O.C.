<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\TareaInstancia;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationsJob implements ShouldQueue
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
        Log::info('Starting SendNotificationsJob');

        // Get pending instances with upcoming due dates
        $instances = TareaInstancia::where('estado', 'PENDIENTE')
            ->whereNotNull('fecha_vencimiento')
            ->with(['cliente', 'contador'])
            ->get();

        foreach ($instances as $instance) {
            try {
                $this->processInstance($instance);
            } catch (\Exception $e) {
                Log::error('Error processing instance ID ' . $instance->id . ': ' . $e->getMessage());
            }
        }

        Log::info('Finished SendNotificationsJob');
    }

    /**
     * Process an instance and create/send notifications if needed.
     *
     * @param TareaInstancia $instance
     */
    private function processInstance(TareaInstancia $instance): void
    {
        // Get the tarea cliente to determine alert days
        $tareaCliente = $instance->tareaCliente;
        if (!$tareaCliente) {
            return;
        }

        $alertDays = $tareaCliente->alerta_dias_antes ?? 7;
        
        // Calculate the notification date
        $notificationDate = $instance->fecha_vencimiento->copy()->subDays($alertDays);
        
        // Check if we should send notification today
        if ($notificationDate->isToday() || $notificationDate->isPast()) {
            // Check if notification already exists to avoid duplicates
            $existingNotification = Notification::where('instancia_id', $instance->id)
                ->where('umbral_days_before', $alertDays)
                ->where('enviado', false)
                ->first();
                
            if (!$existingNotification) {
                // Create notification
                $notification = Notification::create([
                    'instancia_id' => $instance->id,
                    'tipo' => 'email',
                    'destinatario' => $instance->contador && $instance->contador->email ? 
                        $instance->contador->email : 
                        ($instance->cliente->email ?? ''),
                    'umbral_days_before' => $alertDays,
                    'enviado' => false,
                    'payload' => [
                        'subject' => 'Tarea pendiente: ' . $instance->tarea->nombre,
                        'message' => 'La tarea "' . $instance->tarea->nombre . '" para el cliente "' . 
                            $instance->cliente->razon_social . '" vence el ' . 
                            $instance->fecha_vencimiento->format('d/m/Y'),
                    ],
                ]);
                
                // In a real implementation, you would actually send the email here
                // For now, we'll just log it
                Log::info('Created notification ID ' . $notification->id . ' for instance ID ' . $instance->id);
            }
        }
    }
}