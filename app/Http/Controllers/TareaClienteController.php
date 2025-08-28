<?php

namespace App\Http\Controllers;

use App\Models\TareaCliente;
use App\Http\Requests\StoreTareaClienteRequest;
use App\Http\Requests\UpdateTareaClienteRequest;
use Illuminate\Http\Request;

class TareaClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filtering logic will be added here based on query params
        return TareaCliente::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTareaClienteRequest $request)
    {
        $tareaCliente = TareaCliente::create($request->validated());
        return response()->json($tareaCliente, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TareaCliente $tareasCliente)
    {
        return $tareasCliente;
    }

    /**
     * Update the specified resource in storage.
     */
    <?php

namespace App\Http\Controllers;

use App\Models\TareaCliente;
use App\Http\Requests\StoreTareaClienteRequest;
use App\Http\Requests\UpdateTareaClienteRequest;
use Illuminate\Http\Request;

class TareaClienteController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TareaCliente::class, 'tareas_cliente');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filtering logic will be added here based on query params
        return TareaCliente::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTareaClienteRequest $request)
    {
        $tareaCliente = TareaCliente::create($request->validated());
        return response()->json($tareaCliente, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TareaCliente $tareasCliente)
    {
        return $tareasCliente;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTareaClienteRequest $request, TareaCliente $tareasCliente)
    {
        $tareasCliente->update($request->validated());
        return response()->json($tareasCliente, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TareaCliente $tareasCliente)
    {
        $tareasCliente->delete();
        return response()->json(null, 204);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TareaCliente $tareasCliente)
    {
        $tareasCliente->delete();
        return response()->json(null, 204);
    }
}
