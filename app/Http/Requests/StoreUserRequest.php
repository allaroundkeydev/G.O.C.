<?php
//app\Http\Requests\StoreUserRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        return [
            'nombre_completo' => 'required|string|max:200',
            'username' => 'required|string|max:100|unique:users',
            'password' => 'required|string|min:8',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|string|email|max:200|unique:users',
            'rol' => 'required|string|in:admin,contador',
        ];
    }
}
