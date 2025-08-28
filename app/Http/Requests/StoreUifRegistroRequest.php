<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUifRegistroRequest extends FormRequest
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
            'fecha_inscripcion' => 'nullable|date',
            'usuario_nit' => 'nullable|string|max:100',
            'clave_encriptada' => 'nullable|string|max:255',
            'correo_registro' => 'nullable|string|max:200',
        ];
    }
}
