<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTareaInstanciaRequest extends FormRequest
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
            'tarea_id' => 'required|exists:tareas,id',
            'tarea_cliente_id' => 'nullable|exists:tareas_clientes,id',
            'cliente_id' => 'required|exists:clientes,id',
            'contador_id' => 'nullable|exists:users,id',
            'auditor_id' => 'nullable|exists:auditores,id',
            'representante_id' => 'nullable|exists:representantes,id',
            'estado' => 'string',
            'fecha_vencimiento' => 'nullable|date',
            'fecha_realizacion' => 'nullable|date',
            'notas' => 'nullable|string',
            'datos_snapshot' => 'nullable|string', // Should be json validation later
        ];
    }
}
