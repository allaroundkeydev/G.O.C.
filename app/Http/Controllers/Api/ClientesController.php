<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClientesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $clientes = Cliente::with(['representantes', 'actividades', 'cuentas'])
            ->paginate(15);

        return $this->sendResponse($clientes, 'Clientes retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'razon_social' => 'required|string|max:250',
            'dui' => 'nullable|string|max:50|unique:clientes',
            'nit' => 'nullable|string|max:50|unique:clientes',
            'nrc' => 'nullable|string|max:50',
            'fecha_constitucion' => 'nullable|date',
            'fecha_inscripcion' => 'nullable|date',
            'tipo_gobierno' => 'nullable|string|max:100',
        ]);

        $cliente = Cliente::create($validatedData);

        return $this->sendResponse($cliente, 'Cliente created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $cliente = Cliente::with(['representantes', 'actividades', 'cuentas', 'tareasClientes.tarea', 'instancias'])->find($id);

        if (is_null($cliente)) {
            return $this->sendError('Cliente not found.');
        }

        return $this->sendResponse($cliente, 'Cliente retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (is_null($cliente)) {
            return $this->sendError('Cliente not found.');
        }

        $validatedData = $request->validate([
            'razon_social' => 'required|string|max:250',
            'dui' => 'nullable|string|max:50|unique:clientes,dui,' . $id,
            'nit' => 'nullable|string|max:50|unique:clientes,nit,' . $id,
            'nrc' => 'nullable|string|max:50',
            'fecha_constitucion' => 'nullable|date',
            'fecha_inscripcion' => 'nullable|date',
            'tipo_gobierno' => 'nullable|string|max:100',
        ]);

        $cliente->update($validatedData);

        return $this->sendResponse($cliente, 'Cliente updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (is_null($cliente)) {
            return $this->sendError('Cliente not found.');
        }

        $cliente->delete();

        return $this->sendResponse($cliente, 'Cliente deleted successfully.');
    }
}