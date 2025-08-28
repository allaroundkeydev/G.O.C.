<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\TareaInstancia;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send notifications for upcoming task deadlines.
     */
    public function sendUpcomingDeadlineNotifications(): void
    {
        // Get pending instances with upcoming due dates
        $instances = TareaInstancia::where('estado', 'PENDIENTE')
            ->whereNotNull('fecha_vencimiento')
            ->with(['cliente', 'contador', 'tareaCliente.tarea'])
            ->get();

        foreach ($instances as $instance) {
            try {
                $this->processInstance($instance);
            } catch (\Exception $e) {
                Log::error('Error processing instance ID ' . $instance->id . ': ' . $e->getMessage());
            }
        }
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
                    'destinatario' => $this->getRecipientEmail($instance),
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

    /**
     * Get the recipient email for a notification.
     *
     * @param TareaInstancia $instance
     * @return string
     */
    private function getRecipientEmail(TareaInstancia $instance): string
    {
        // Try contador email first
        if ($instance->contador && $instance->contador->email) {
            return $instance->contador->email;
        }
        
        // Try client email
        if ($instance->cliente && $instance->cliente->email) {
            return $instance->cliente->email;
        }
        
        // Default to empty string
        return '';
    }

    /**
     * Mark a notification as sent.
     *
     * @param Notification $notification
     */
    public function markAsSent(Notification $notification): void
    {
        $notification->update([
            'enviado' => true,
            'enviado_at' => now(),
        ]);
    }
}