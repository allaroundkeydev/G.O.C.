<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    /**
     * Login api
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['token'] = $user->createToken('SCA-Contable')->plainTextToken;
            $success['name'] = $user->nombre_completo;
            $success['rol'] = $user->rol;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        }
    }

    /**
     * Register api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_completo' => 'required|string|max:200',
            'username' => 'required|string|max:100|unique:users',
            'password' => 'required|string|min:8',
            'email' => 'nullable|email|max:200|unique:users',
            'rol' => 'required|in:admin,contador',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['estado'] = 'ACTIVO';

        $user = User::create($validatedData);
        $success['token'] = $user->createToken('SCA-Contable')->plainTextToken;
        $success['name'] = $user->nombre_completo;
        $success['rol'] = $user->rol;

        return $this->sendResponse($success, 'User registered successfully.');
    }

    /**
     * Logout api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse(null, 'User logged out successfully.');
    }
}