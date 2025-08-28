<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHaciendaPresentacionRequest extends FormRequest
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
            'tipo_presentacion' => 'sometimes|required|string|max:50',
            'fecha_presentacion' => 'sometimes|nullable|date',
            'monto' => 'sometimes|nullable|numeric|between:0,9999999999999999.99',
            'observaciones' => 'sometimes|nullable|string',
        ];
    }
}
