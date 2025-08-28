<?php

namespace App\Http\Controllers;

use App\Models\MtContrato;
use App\Http\Requests\StoreMtContratoRequest;
use App\Http\Requests\UpdateMtContratoRequest;
use Illuminate\Http\Request;

class MtContratoController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MtContrato::class, 'mt_contrato');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMtContratoRequest $request)
    {
        $mtContrato = MtContrato::create($request->validated());
        return response()->json($mtContrato, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMtContratoRequest $request, MtContrato $mtContrato)
    {
        $mtContrato->update($request->validated());
        return response()->json($mtContrato, 200);
    }
}
