<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTareaCampoRequest extends FormRequest
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
        $tareaCampoId = $this->route('campo')->id;

        return [
            'tarea_id' => 'sometimes|required|exists:tareas,id',
            'nombre' => [
                'sometimes',
                'required',
                'string',
                'max:150',
                Rule::unique('tareas_campos')->where(function ($query) {
                    return $query->where('tarea_id', $this->tarea_id);
                })->ignore($tareaCampoId),
            ],
            'etiqueta' => 'sometimes|nullable|string|max:200',
            'descripcion' => 'sometimes|nullable|string',
            'tipo' => 'sometimes|required|string|in:numerico,texto,fecha,booleano,entidad,lista,moneda',
            'obligatorio' => 'sometimes|boolean',
            'opciones' => 'sometimes|nullable|string', // Should be json validation later
            'orden' => 'sometimes|integer',
            'meta' => 'sometimes|nullable|string', // Should be json validation later
        ];
    }
}
