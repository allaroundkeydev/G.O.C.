<?php

namespace App\Http\Controllers;

use App\Models\TareaInstancia;
use App\Http\Requests\StoreTareaInstanciaRequest;
use App\Http\Requests\UpdateTareaInstanciaRequest;
use Illuminate\Http\Request;

class TareaInstanciaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TareaInstancia::class, 'instancia');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filtering logic will be added here based on query params
        return TareaInstancia::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTareaInstanciaRequest $request)
    {
        $tareaInstancia = TareaInstancia::create($request->validated());
        return response()->json($tareaInstancia, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TareaInstancia $instancia)
    {
        return $instancia;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTareaInstanciaRequest $request, TareaInstancia $instancia)
    {
        $instancia->update($request->validated());
        return response()->json($instancia, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TareaInstancia $instancia)
    {
        $instancia->delete();
        return response()->json(null, 204);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeValores(Request $request, TareaInstancia $instancia)
    {
        // Logic to store a TareaInstanciaValor will be added here
        return response()->json(null, 201);
    }
}
