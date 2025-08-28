<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Tarea;
use App\Models\TareaCampo;
use App\Models\TareaCliente;
use Illuminate\Http\Request;

class TareasController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $tareas = Tarea::with(['institucion', 'createdBy', 'campos'])
            ->paginate(15);

        return $this->sendResponse($tareas, 'Tareas retrieved successfully.');
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
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'institucion_id' => 'nullable|exists:instituciones,id',
            'created_by' => 'nullable|exists:users,id',
        ]);

        $tarea = Tarea::create($validatedData);

        return $this->sendResponse($tarea, 'Tarea created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $tarea = Tarea::with(['institucion', 'createdBy', 'campos', 'tareasClientes.cliente', 'instancias'])->find($id);

        if (is_null($tarea)) {
            return $this->sendError('Tarea not found.');
        }

        return $this->sendResponse($tarea, 'Tarea retrieved successfully.');
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
        $tarea = Tarea::find($id);

        if (is_null($tarea)) {
            return $this->sendError('Tarea not found.');
        }

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'institucion_id' => 'nullable|exists:instituciones,id',
            'created_by' => 'nullable|exists:users,id',
        ]);

        $tarea->update($validatedData);

        return $this->sendResponse($tarea, 'Tarea updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $tarea = Tarea::find($id);

        if (is_null($tarea)) {
            return $this->sendError('Tarea not found.');
        }

        $tarea->delete();

        return $this->sendResponse($tarea, 'Tarea deleted successfully.');
    }

    /**
     * Get campos for a tarea.
     *
     * @param int $tarea_id
     * @return JsonResponse
     */
    public function getCampos($tarea_id)
    {
        $tarea = Tarea::find($tarea_id);

        if (is_null($tarea)) {
            return $this->sendError('Tarea not found.');
        }

        $campos = $tarea->campos()->orderBy('orden')->get();

        return $this->sendResponse($campos, 'Campos retrieved successfully.');
    }

    /**
     * Create a new campo for a tarea.
     *
     * @param Request $request
     * @param int $tarea_id
     * @return JsonResponse
     */
    public function createCampo(Request $request, $tarea_id)
    {
        $tarea = Tarea::find($tarea_id);

        if (is_null($tarea)) {
            return $this->sendError('Tarea not found.');
        }

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'etiqueta' => 'nullable|string|max:200',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:numerico,texto,fecha,booleano,entidad,lista,moneda',
            'obligatorio' => 'boolean',
            'opciones' => 'nullable|string',
            'orden' => 'integer',
            'meta' => 'nullable|string',
        ]);

        $validatedData['tarea_id'] = $tarea_id;
        $campo = TareaCampo::create($validatedData);

        return $this->sendResponse($campo, 'Campo created successfully.');
    }

    /**
     * Update a campo.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateCampo(Request $request, $id)
    {
        $campo = TareaCampo::find($id);

        if (is_null($campo)) {
            return $this->sendError('Campo not found.');
        }

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'etiqueta' => 'nullable|string|max:200',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:numerico,texto,fecha,booleano,entidad,lista,moneda',
            'obligatorio' => 'boolean',
            'opciones' => 'nullable|string',
            'orden' => 'integer',
            'meta' => 'nullable|string',
        ]);

        $campo->update($validatedData);

        return $this->sendResponse($campo, 'Campo updated successfully.');
    }

    /**
     * Delete a campo.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteCampo($id)
    {
        $campo = TareaCampo::find($id);

        if (is_null($campo)) {
            return $this->sendError('Campo not found.');
        }

        $campo->delete();

        return $this->sendResponse($campo, 'Campo deleted successfully.');
    }

    /**
     * Assign tarea to cliente.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function assignToCliente(Request $request)
    {
        $validatedData = $request->validate([
            'tarea_id' => 'required|exists:tareas,id',
            'cliente_id' => 'required|exists:clientes,id',
            'contador_id' => 'nullable|exists:users,id',
            'auditor_id' => 'nullable|exists:auditores,id',
            'representante_id' => 'nullable|exists:representantes,id',
            'institucion_id' => 'nullable|exists:instituciones,id',
            'recurrence_rule' => 'nullable|string',
            'alerta_dias_antes' => 'integer|min:0',
            'activo' => 'boolean',
        ]);

        $tareaCliente = TareaCliente::create($validatedData);

        return $this->sendResponse($tareaCliente, 'Tarea assigned to cliente successfully.');
    }

    /**
     * List tareas clientes.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listTareasClientes(Request $request)
    {
        $query = TareaCliente::with(['tarea', 'cliente', 'contador', 'auditor', 'representante', 'institucion']);

        if ($request->has('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->has('tarea_id')) {
            $query->where('tarea_id', $request->tarea_id);
        }

        if ($request->has('activo')) {
            $query->where('activo', $request->activo);
        }

        $tareasClientes = $query->paginate(15);

        return $this->sendResponse($tareasClientes, 'Tareas clientes retrieved successfully.');
    }

    /**
     * Update tarea cliente.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateTareaCliente(Request $request, $id)
    {
        $tareaCliente = TareaCliente::find($id);

        if (is_null($tareaCliente)) {
            return $this->sendError('Tarea cliente not found.');
        }

        $validatedData = $request->validate([
            'contador_id' => 'nullable|exists:users,id',
            'auditor_id' => 'nullable|exists:auditores,id',
            'representante_id' => 'nullable|exists:representantes,id',
            'institucion_id' => 'nullable|exists:instituciones,id',
            'recurrence_rule' => 'nullable|string',
            'alerta_dias_antes' => 'integer|min:0',
            'activo' => 'boolean',
        ]);

        $tareaCliente->update($validatedData);

        return $this->sendResponse($tareaCliente, 'Tarea cliente updated successfully.');
    }

    /**
     * Delete tarea cliente.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteTareaCliente($id)
    {
        $tareaCliente = TareaCliente::find($id);

        if (is_null($tareaCliente)) {
            return $this->sendError('Tarea cliente not found.');
        }

        $tareaCliente->delete();

        return $this->sendResponse($tareaCliente, 'Tarea cliente deleted successfully.');
    }
}