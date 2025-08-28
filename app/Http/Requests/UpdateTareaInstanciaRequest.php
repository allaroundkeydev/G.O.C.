<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTareaInstanciaRequest extends FormRequest
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
            'tarea_id' => 'sometimes|required|exists:tareas,id',
            'tarea_cliente_id' => 'sometimes|nullable|exists:tareas_clientes,id',
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'contador_id' => 'sometimes|nullable|exists:users,id',
            'auditor_id' => 'sometimes|nullable|exists:auditores,id',
            'representante_id' => 'sometimes|nullable|exists:representantes,id',
            'estado' => 'sometimes|string',
            'fecha_vencimiento' => 'sometimes|nullable|date',
            'fecha_realizacion' => 'sometimes|nullable|date',
            'notas' => 'sometimes|nullable|string',
            'datos_snapshot' => 'sometimes|nullable|string', // Should be json validation later
        ];
    }
}
