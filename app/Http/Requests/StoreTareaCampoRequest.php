<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTareaCampoRequest extends FormRequest
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
            'nombre' => [
                'required',
                'string',
                'max:150',
                Rule::unique('tareas_campos')->where(function ($query) {
                    return $query->where('tarea_id', $this->tarea_id);
                }),
            ],
            'etiqueta' => 'nullable|string|max:200',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|string|in:numerico,texto,fecha,booleano,entidad,lista,moneda',
            'obligatorio' => 'boolean',
            'opciones' => 'nullable|string', // Should be json validation later
            'orden' => 'integer',
            'meta' => 'nullable|string', // Should be json validation later
        ];
    }
}
