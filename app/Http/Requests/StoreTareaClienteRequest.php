<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTareaClienteRequest extends FormRequest
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
            'tarea_id' => [
                'required',
                'exists:tareas,id',
                Rule::unique('tareas_clientes')->where(function ($query) {
                    return $query->where('cliente_id', $this->cliente_id);
                }),
            ],
            'cliente_id' => 'required|exists:clientes,id',
            'contador_id' => 'nullable|exists:users,id',
            'auditor_id' => 'nullable|exists:auditores,id',
            'representante_id' => 'nullable|exists:representantes,id',
            'institucion_id' => 'nullable|exists:instituciones,id',
            'recurrence_rule' => 'nullable|string',
            'alerta_dias_antes' => 'integer',
            'activo' => 'boolean',
        ];
    }
}
