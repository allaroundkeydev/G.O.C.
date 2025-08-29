<?php
// app/Http/Requests/StoreClienteRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Podrías validar con policies: $this->user()->can('create', Cliente::class);
        return true;
    }

    public function rules(): array
    {
        return [
            'razon_social'         => 'required|string|max:250',
            'dui'                  => 'nullable|string|max:50|unique:clientes,dui',
            'nit'                  => 'nullable|string|max:50|unique:clientes,nit',
            'nrc'                  => 'nullable|string|max:50',
            'fecha_constitucion'   => 'nullable|date',
            'fecha_inscripcion'    => 'nullable|date',
            'tipo_gobierno'        => 'nullable|string|max:100',
        ];
    }
}