<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTareaRequest extends FormRequest
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
            'nombre' => 'sometimes|required|string|max:200',
            'descripcion' => 'sometimes|nullable|string',
            'institucion_id' => 'sometimes|nullable|exists:instituciones,id',
            'created_by' => 'sometimes|nullable|exists:users,id',
        ];
    }
}
