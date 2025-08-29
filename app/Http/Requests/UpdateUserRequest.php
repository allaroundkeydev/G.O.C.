<?php
// app/Http/Requests/UpdateUserRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Podrías validar con policies:
        // return $this->user()->can('update', $this->route('user'));
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'nombre_completo' => 'required|string|max:200',
            'username'        => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            // Permitimos que quede vacío (no cambie) o cumpla min:8
            'password'        => 'nullable|string|min:8',
            'telefono'        => 'nullable|string|max:50',
            'email'           => [
                'nullable',
                'email',
                'max:200',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'rol'             => 'required|in:admin,contador',
            'estado'          => 'nullable|in:ACTIVO,INACTIVO',
        ];
    }
}