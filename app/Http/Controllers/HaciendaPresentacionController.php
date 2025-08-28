<?php

namespace App\Http\Controllers;

use App\Models\HaciendaPresentacion;
use App\Http\Requests\StoreHaciendaPresentacionRequest;
use App\Http\Requests\UpdateHaciendaPresentacionRequest;
use Illuminate\Http\Request;

class HaciendaPresentacionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(HaciendaPresentacion::class, 'hacienda_presentacion');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHaciendaPresentacionRequest $request)
    {
        $haciendaPresentacion = HaciendaPresentacion::create($request->validated());
        return response()->json($haciendaPresentacion, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHaciendaPresentacionRequest $request, HaciendaPresentacion $haciendaPresentacion)
    {
        $haciendaPresentacion->update($request->validated());
        return response()->json($haciendaPresentacion, 200);
    }
}
