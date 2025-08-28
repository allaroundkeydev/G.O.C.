<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMtContratoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'fecha_contrato' => 'sometimes|required|date',
            'descripcion' => 'sometimes|nullable|string',
            'archivo_referencia' => 'sometimes|nullable|string|max:255',
        ];
    }
}
