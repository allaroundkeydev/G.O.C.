<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHaciendaPresentacionRequest extends FormRequest
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
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_presentacion' => 'required|string|max:50',
            'fecha_presentacion' => 'nullable|date',
            'monto' => 'nullable|numeric|between:0,9999999999999999.99',
            'observaciones' => 'nullable|string',
        ];
    }
}
