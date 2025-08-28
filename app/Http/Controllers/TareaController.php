<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;

class TareaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Tarea::class, 'tarea');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tarea::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTareaRequest $request)
    {
        $tarea = Tarea::create($request->validated());
        return response()->json($tarea, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        return $tarea;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTareaRequest $request, Tarea $tarea)
    {
        $tarea->update($request->validated());
        return response()->json($tarea, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        $tarea->delete();
        return response()->json(null, 204);
    }
}