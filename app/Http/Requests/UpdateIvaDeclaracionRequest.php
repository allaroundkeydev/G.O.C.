<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIvaDeclaracionRequest extends FormRequest
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
            'periodo_inicio' => 'sometimes|required|date',
            'periodo_fin' => 'sometimes|required|date',
            'fecha_presentacion' => 'sometimes|nullable|date',
            'monto_a_pagar' => 'sometimes|nullable|numeric|between:0,9999999999999999.99',
            'plazo' => 'sometimes|boolean',
            'cantidad_cuotas' => 'sometimes|integer',
            'dia_pago' => 'sometimes|nullable|integer',
        ];
    }
}
