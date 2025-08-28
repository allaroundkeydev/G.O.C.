<?php

namespace App\Http\Controllers;

use App\Models\UifRegistro;
use Illuminate\Http\Request;

class UifRegistroController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation logic will be added here
        $uifRegistro = UifRegistro::create($request->all());
        return response()->json($uifRegistro, 201);
    }
}
