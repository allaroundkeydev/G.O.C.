<?php
// app/Http/Requests/StoreClienteRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

public function rules(): array
{
    return [
        'razon_social' => 'required|string|max:250',
        'dui' => 'nullable|string|max:50|unique:clientes,dui',
        'nit' => 'nullable|string|max:50|unique:clientes,nit',
        'nrc' => 'nullable|string|max:50',
        'fecha_constitucion' => 'nullable|date',
        'fecha_inscripcion' => 'nullable|date',
        'tipo_gobierno' => 'nullable|string|max:100',

        // Representantes pivot
        'representantes' => 'sometimes|array',
        'representantes.*.id' => 'required|integer|exists:representantes,id',
        'representantes.*.fecha_nombramiento' => 'nullable|date',
        'representantes.*.duracion_meses' => 'nullable|integer|min:1',
        'representantes.*.fecha_fin_nombramiento' => 'nullable|date|after_or_equal:representantes.*.fecha_nombramiento',
        'representantes.*.numero_acta' => 'nullable|string|max:100',
        'representantes.*.numero_acuerdo' => 'nullable|string|max:100',
        'representantes.*.activo' => 'nullable|boolean',

        // Auditores pivot
        'auditores' => 'sometimes|array',
        'auditores.*.id' => 'required|integer|exists:auditores,id',
        'auditores.*.fecha_nombramiento' => 'nullable|date',
        'auditores.*.fecha_fin_nombramiento' => 'nullable|date|after_or_equal:auditores.*.fecha_nombramiento',
        'auditores.*.activo' => 'nullable|boolean',
        'auditores.*.notas' => 'nullable|string|max:500',
    ];
}
