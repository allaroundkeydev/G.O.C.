<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // We will handle authorization with policies
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'nombre_completo' => 'sometimes|required|string|max:200',
            'username' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => 'sometimes|required|string|min:8',
            'telefono' => 'nullable|string|max:50',
            'email' => [
                'nullable',
                'string',
                'email',
                'max:200',
                Rule::unique('users')->ignore($userId),
            ],
            'rol' => 'sometimes|required|string|in:admin,contador',
        ];
    }
}
