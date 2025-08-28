<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\TareaInstancia;
use App\Models\TareaInstanciaValor;
use Illuminate\Http\Request;

class TareasInstanciasController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = TareaInstancia::with(['tarea', 'cliente', 'contador', 'auditor', 'representante']);

        if ($request->has('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->has('contador_id')) {
            $query->where('contador_id', $request->contador_id);
        }

        $instancias = $query->paginate(15);

        return $this->sendResponse($instancias, 'Instancias retrieved successfully.');
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
            'tarea_id' => 'required|exists:tareas,id',
            'tarea_cliente_id' => 'nullable|exists:tareas_clientes,id',
            'cliente_id' => 'required|exists:clientes,id',
            'contador_id' => 'nullable|exists:users,id',
            'auditor_id' => 'nullable|exists:auditores,id',
            'representante_id' => 'nullable|exists:representantes,id',
            'estado' => 'required|in:PENDIENTE,COMPLETADO,EN_PROCESO,CANCELADO',
            'fecha_vencimiento' => 'nullable|date',
            'fecha_realizacion' => 'nullable|date',
            'notas' => 'nullable|string',
            'datos_snapshot' => 'nullable|array',
        ]);

        $instancia = TareaInstancia::create($validatedData);

        return $this->sendResponse($instancia, 'Instancia created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $instancia = TareaInstancia::with(['tarea', 'cliente', 'contador', 'auditor', 'representante', 'valores.campo'])->find($id);

        if (is_null($instancia)) {
            return $this->sendError('Instancia not found.');
        }

        return $this->sendResponse($instancia, 'Instancia retrieved successfully.');
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
        $instancia = TareaInstancia::find($id);

        if (is_null($instancia)) {
            return $this->sendError('Instancia not found.');
        }

        $validatedData = $request->validate([
            'contador_id' => 'nullable|exists:users,id',
            'auditor_id' => 'nullable|exists:auditores,id',
            'representante_id' => 'nullable|exists:representantes,id',
            'estado' => 'in:PENDIENTE,COMPLETADO,EN_PROCESO,CANCELADO',
            'fecha_vencimiento' => 'nullable|date',
            'fecha_realizacion' => 'nullable|date',
            'notas' => 'nullable|string',
            'datos_snapshot' => 'nullable|array',
        ]);

        $instancia->update($validatedData);

        return $this->sendResponse($instancia, 'Instancia updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $instancia = TareaInstancia::find($id);

        if (is_null($instancia)) {
            return $this->sendError('Instancia not found.');
        }

        $instancia->delete();

        return $this->sendResponse($instancia, 'Instancia deleted successfully.');
    }

    /**
     * Save valores for an instancia.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function saveValores(Request $request, $id)
    {
        $instancia = TareaInstancia::find($id);

        if (is_null($instancia)) {
            return $this->sendError('Instancia not found.');
        }

        $validatedData = $request->validate([
            'valores' => 'required|array',
            'valores.*.campo_id' => 'required|exists:tareas_campos,id',
            'valores.*.valor_text' => 'nullable|string',
            'valores.*.valor_num' => 'nullable|numeric',
            'valores.*.valor_fecha' => 'nullable|date',
            'valores.*.valor_bool' => 'nullable|boolean',
            'valores.*.valor_entity_type' => 'nullable|string|max:100',
            'valores.*.valor_entity_id' => 'nullable|integer',
        ]);

        foreach ($validatedData['valores'] as $valorData) {
            $valorData['instancia_id'] = $id;
            
            TareaInstanciaValor::updateOrCreate(
                ['instancia_id' => $id, 'campo_id' => $valorData['campo_id']],
                $valorData
            );
        }

        // Reload the instancia with valores
        $instancia = TareaInstancia::with(['valores.campo'])->find($id);

        return $this->sendResponse($instancia, 'Valores saved successfully.');
    }
}