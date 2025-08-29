<?php
// app/Http/Controllers/ClienteController.php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Cliente::class, 'cliente');
    }

    // 1. Listado con paginación
    public function index(): View
    {
        $clientes = Cliente::orderByDesc('id')->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    // 2. Formulario creación
    public function create(): View
    {
        return view('clientes.create');
    }

    // 3. Guardar nuevo
    public function store(StoreClienteRequest $request): RedirectResponse
    {
        Cliente::create($request->validated());

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    // 4. Ver detalle (opcional)
    public function show(Cliente $cliente): View
    {
        return view('clientes.show', compact('cliente'));
    }

    // 5. Formulario edición
    public function edit(Cliente $cliente): View
    {
        return view('clientes.edit', compact('cliente'));
    }

    // 6. Actualizar registro
    public function update(UpdateClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $cliente->update($request->validated());

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    // 7. Eliminar (soft delete)
    public function destroy(Cliente $cliente): RedirectResponse
    {
        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}