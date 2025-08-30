<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuditorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'             => 'required|string|max:200',
            'telefono'           => 'nullable|string|max:50',
            'correo_electronico' => 'nullable|email|max:200',
            'empresa'            => 'nullable|string|max:200',
            'num_vpcpa'          => 'nullable|string|max:100',
            'nombrado'           => 'nullable|boolean',
        ];
    }
}