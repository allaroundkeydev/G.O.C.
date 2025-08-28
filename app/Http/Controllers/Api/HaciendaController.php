<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\IvaDeclaracion;
use App\Models\HaciendaPresentacion;
use Illuminate\Http\Request;

class HaciendaController extends BaseController
{
    /**
     * Create a new IVA declaration.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createIvaDeclaration(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'periodo_inicio' => 'required|date',
            'periodo_fin' => 'required|date',
            'fecha_presentacion' => 'nullable|date',
            'monto_a_pagar' => 'nullable|numeric',
            'plazo' => 'boolean',
            'cantidad_cuotas' => 'integer',
            'dia_pago' => 'nullable|integer|min:1|max:31',
        ]);

        $ivaDeclaration = IvaDeclaracion::create($validatedData);

        return $this->sendResponse($ivaDeclaration, 'IVA declaration created successfully.');
    }

    /**
     * List recent IVA declarations for a client.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listRecentIvaDeclarations(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'limit' => 'integer|min:1|max:100',
        ]);

        $limit = $validatedData['limit'] ?? 6;

        $declarations = IvaDeclaracion::where('cliente_id', $validatedData['cliente_id'])
            ->orderBy('fecha_presentacion', 'desc')
            ->limit($limit)
            ->get();

        return $this->sendResponse($declarations, 'IVA declarations retrieved successfully.');
    }

    /**
     * Create a new Hacienda presentation.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createHaciendaPresentation(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_presentacion' => 'required|string|max:50',
            'fecha_presentacion' => 'nullable|date',
            'monto' => 'nullable|numeric',
            'observaciones' => 'nullable|string',
        ]);

        $presentation = HaciendaPresentacion::create($validatedData);

        return $this->sendResponse($presentation, 'Hacienda presentation created successfully.');
    }
}