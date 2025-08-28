<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIvaDeclaracionRequest extends FormRequest
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
            'periodo_inicio' => 'required|date',
            'periodo_fin' => 'required|date',
            'fecha_presentacion' => 'nullable|date',
            'monto_a_pagar' => 'nullable|numeric|between:0,9999999999999999.99',
            'plazo' => 'boolean',
            'cantidad_cuotas' => 'integer',
            'dia_pago' => 'nullable|integer',
        ];
    }
}
