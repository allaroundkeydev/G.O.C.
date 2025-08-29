<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * 1. Listado de usuarios con paginación.
     */
    public function index(): View
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * 2. Mostrar formulario de creación.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * 3. Almacenar nuevo usuario y redirigir.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        // Hashear contraseña
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * 4. Ver detalles de un usuario (opcional).
     */
    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    /**
     * 5. Mostrar formulario de edición.
     */
    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * 6. Actualizar usuario y redirigir.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['password']) && $data['password'] !== '') {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * 7. Eliminar (soft delete) y redirigir.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}