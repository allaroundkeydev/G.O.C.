<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
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
        $clienteId = $this->route('cliente')->id;

        return [
            'razon_social' => 'sometimes|required|string|max:250',
            'dui' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('clientes')->ignore($clienteId),
            ],
            'nit' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('clientes')->ignore($clienteId),
            ],
            'nrc' => 'nullable|string|max:50',
            'fecha_constitucion' => 'nullable|date',
            'fecha_inscripcion' => 'nullable|date',
            'tipo_gobierno' => 'nullable|string|max:100',
        ];
    }
}
