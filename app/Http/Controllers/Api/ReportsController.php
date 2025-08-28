<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\TareaInstancia;
use Illuminate\Http\Request;

class ReportsController extends BaseController
{
    /**
     * Get tasks due within a certain number of days.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function tasksDue(Request $request)
    {
        $validatedData = $request->validate([
            'days' => 'integer|min:1|max:365',
        ]);

        $days = $validatedData['days'] ?? 7;

        $tasks = TareaInstancia::with(['tarea', 'cliente', 'contador'])
            ->where('estado', 'PENDIENTE')
            ->whereBetween('fecha_vencimiento', [now(), now()->addDays($days)])
            ->orderBy('fecha_vencimiento')
            ->get();

        return $this->sendResponse($tasks, 'Tasks due retrieved successfully.');
    }

    /**
     * Get tasks by status.
     *
     * @return JsonResponse
     */
    public function tasksByStatus()
    {
        $tasks = TareaInstancia::select('estado', \DB::raw('count(*) as count'))
            ->groupBy('estado')
            ->get();

        return $this->sendResponse($tasks, 'Tasks by status retrieved successfully.');
    }
}