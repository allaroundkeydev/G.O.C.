<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\UifRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UifController extends BaseController
{
    /**
     * Register a new UIF registration.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_inscripcion' => 'nullable|date',
            'usuario_nit' => 'nullable|string|max:100',
            'clave' => 'nullable|string|max:255',
            'correo_registro' => 'nullable|email|max:200',
        ]);

        // Encrypt the clave if provided
        if (isset($validatedData['clave'])) {
            $validatedData['clave_encriptada'] = Crypt::encryptString($validatedData['clave']);
            unset($validatedData['clave']);
        }

        $registro = UifRegistro::create($validatedData);

        return $this->sendResponse($registro, 'UIF registration created successfully.');
    }
}