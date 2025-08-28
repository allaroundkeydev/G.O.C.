<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\MtContrato;
use Illuminate\Http\Request;

class MtController extends BaseController
{
    /**
     * Upload a new contract.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadContract(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_contrato' => 'required|date',
            'descripcion' => 'nullable|string',
            'archivo_referencia' => 'nullable|string|max:255',
        ]);

        $contrato = MtContrato::create($validatedData);

        return $this->sendResponse($contrato, 'Contract uploaded successfully.');
    }
}