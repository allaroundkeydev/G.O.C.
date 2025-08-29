<?php
// app/Http/Requests/UpdateClienteRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Podrías validar con policies: $this->user()->can('update', $this->route('cliente'));
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('cliente')->id;

        return [
            'razon_social'       => 'required|string|max:250',
            'dui'                => [
                'nullable','string','max:50',
                Rule::unique('clientes','dui')->ignore($id),
            ],
            'nit'                => [
                'nullable','string','max:50',
                Rule::unique('clientes','nit')->ignore($id),
            ],
            'nrc'                => 'nullable|string|max:50',
            'fecha_constitucion' => 'nullable|date',
            'fecha_inscripcion'  => 'nullable|date',
            'tipo_gobierno'      => 'nullable|string|max:100',
        ];
    }
}