<?php
// app/Http/Requests/StoreUserRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Podrías validar aquí con policies:
        // return $this->user()->can('create', User::class);
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_completo' => 'required|string|max:200',
            'username'        => 'required|string|max:100|unique:users,username',
            'password'        => 'required|string|min:8',
            'telefono'        => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:200|unique:users,email',
            'rol'             => 'required|in:admin,contador',
            // Agregamos validación para estado, opcional pero limitado
            'estado'          => 'nullable|in:ACTIVO,INACTIVO',
        ];
    }
}