<?php

namespace App\Jobs;

use App\Models\IvaDeclaracion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PruneIvaHistoryJob implements ShouldQueue
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
        Log::info('Starting PruneIvaHistoryJob');

        // Get all clients
        $clients = DB::table('clientes')->pluck('id');

        foreach ($clients as $clientId) {
            try {
                $this->pruneClientIvaHistory($clientId);
            } catch (\Exception $e) {
                Log::error('Error pruning IVA history for client ID ' . $clientId . ': ' . $e->getMessage());
            }
        }

        Log::info('Finished PruneIvaHistoryJob');
    }

    /**
     * Prune IVA history for a specific client, keeping only the last 6 declarations.
     *
     * @param int $clientId
     */
    private function pruneClientIvaHistory(int $clientId): void
    {
        // Get the IDs of the 6 most recent declarations for this client
        $recentDeclarations = IvaDeclaracion::where('cliente_id', $clientId)
            ->orderBy('fecha_presentacion', 'desc')
            ->limit(6)
            ->pluck('id');

        // Delete all declarations except the 6 most recent ones
        $deletedCount = IvaDeclaracion::where('cliente_id', $clientId)
            ->whereNotIn('id', $recentDeclarations)
            ->delete();

        if ($deletedCount > 0) {
            Log::info('Deleted ' . $deletedCount . ' old IVA declarations for client ID ' . $clientId);
        }
    }
}