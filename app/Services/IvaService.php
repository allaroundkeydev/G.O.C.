<?php

namespace App\Services;

use App\Models\IvaDeclaracion;
use Illuminate\Support\Facades\DB;

class IvaService
{
    /**
     * Prune IVA history for a client, keeping only the last N declarations.
     *
     * @param int $clientId
     * @param int $keepCount Number of declarations to keep
     */
    public function pruneIvaHistory(int $clientId, int $keepCount = 6): void
    {
        // Get the IDs of the declarations to keep (the most recent ones)
        $declarationsToKeep = IvaDeclaracion::where('cliente_id', $clientId)
            ->orderBy('fecha_presentacion', 'desc')
            ->limit($keepCount)
            ->pluck('id');

        // Delete all declarations except the ones to keep
        IvaDeclaracion::where('cliente_id', $clientId)
            ->whereNotIn('id', $declarationsToKeep)
            ->delete();
    }

    /**
     * Prune IVA history for all clients.
     *
     * @param int $keepCount Number of declarations to keep per client
     */
    public function pruneAllIvaHistory(int $keepCount = 6): void
    {
        // Get all clients
        $clients = DB::table('clientes')->pluck('id');

        foreach ($clients as $clientId) {
            $this->pruneIvaHistory($clientId, $keepCount);
        }
    }
}