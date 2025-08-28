<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTareaClienteRequest extends FormRequest
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
        $tareaClienteId = $this->route('tareas_cliente')->id;

        return [
            'tarea_id' => [
                'sometimes',
                'required',
                'exists:tareas,id',
                Rule::unique('tareas_clientes')->where(function ($query) {
                    return $query->where('cliente_id', $this->cliente_id);
                })->ignore($tareaClienteId),
            ],
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'contador_id' => 'sometimes|nullable|exists:users,id',
            'auditor_id' => 'sometimes|nullable|exists:auditores,id',
            'representante_id' => 'sometimes|nullable|exists:representantes,id',
            'institucion_id' => 'sometimes|nullable|exists:instituciones,id',
            'recurrence_rule' => 'sometimes|nullable|string',
            'alerta_dias_antes' => 'sometimes|integer',
            'activo' => 'sometimes|boolean',
        ];
    }
}
