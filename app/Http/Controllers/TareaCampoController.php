<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\TareaCampo;
use App\Http\Requests\StoreTareaCampoRequest;
use App\Http\Requests\UpdateTareaCampoRequest;

class TareaCampoController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TareaCampo::class, 'campo');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Tarea $tarea)
    {
        return $tarea->campos;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTareaCampoRequest $request, Tarea $tarea)
    {
        $campo = $tarea->campos()->create($request->validated());
        return response()->json($campo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TareaCampo $campo)
    {
        return $campo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTareaCampoRequest $request, TareaCampo $campo)
    {
        $campo->update($request->validated());
        return response()->json($campo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TareaCampo $campo)
    {
        $campo->delete();
        return response()->json(null, 204);
    }
}