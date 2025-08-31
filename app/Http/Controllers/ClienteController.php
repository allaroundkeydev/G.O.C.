<?php
// app/Http/Controllers/ClienteController.php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Representante;
use App\Models\Auditor;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function create(): View
    {
        $representantes = Representante::orderBy('nombre')->get(['id','nombre']);
        $auditores = Auditor::orderBy('nombre')->get(['id','nombre']);
        return view('clientes.create', compact('representantes','auditores'));
    }

    public function edit(Cliente $cliente): View
    {
        $representantes = Representante::orderBy('nombre')->get(['id','nombre']);
        $auditores = Auditor::orderBy('nombre')->get(['id','nombre']);
        // Cargar relaciones con pivote para prellenar
        $cliente->load(['representantes', 'auditores']);
        return view('clientes.edit', compact('cliente','representantes','auditores'));
    }

    public function store(StoreClienteRequest $request): RedirectResponse
    {
        $cliente = Cliente::create($request->validated());

        // Sync si llegan relaciones
        $this->syncRepresentantes($cliente, $request->input('representantes', []));
        $this->syncAuditores($cliente, $request->input('auditores', []));

        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente.');
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $cliente->update($request->validated());

        $this->syncRepresentantes($cliente, $request->input('representantes', []));
        $this->syncAuditores($cliente, $request->input('auditores', []));

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    // Helpers privados
    private function syncRepresentantes(Cliente $cliente, array $rows): void
    {
        $data = collect($rows)
            ->filter(fn($r) => !empty($r['id']))
            ->mapWithKeys(function ($r) {
                return [
                    (int)$r['id'] => [
                        'fecha_nombramiento' => Arr::get($r, 'fecha_nombramiento'),
                        'duracion_meses' => Arr::get($r, 'duracion_meses'),
                        'fecha_fin_nombramiento' => Arr::get($r, 'fecha_fin_nombramiento'),
                        'numero_acta' => Arr::get($r, 'numero_acta'),
                        'numero_acuerdo' => Arr::get($r, 'numero_acuerdo'),
                        'activo' => filter_var(Arr::get($r, 'activo', true), FILTER_VALIDATE_BOOLEAN),
                    ]
                ];
            })->all();

        if (!empty($data)) {
            $cliente->representantes()->sync($data);
        }
    }

    private function syncAuditores(Cliente $cliente, array $rows): void
    {
        $data = collect($rows)
            ->filter(fn($r) => !empty($r['id']))
            ->mapWithKeys(function ($r) {
                return [
                    (int)$r['id'] => [
                        'fecha_nombramiento' => Arr::get($r, 'fecha_nombramiento'),
                        'fecha_fin_nombramiento' => Arr::get($r, 'fecha_fin_nombramiento'),
                        'activo' => filter_var(Arr::get($r, 'activo', true), FILTER_VALIDATE_BOOLEAN),
                        'notas' => Arr::get($r, 'notas'),
                    ]
                ];
            })->all();

        if (!empty($data)) {
            $cliente->auditores()->sync($data);
        }
    }

    public function formAsignarAuditor(Cliente $cliente)
{
    $auditorActual = $cliente->auditores()
        ->wherePivot('activo', true)
        ->orderByDesc('fecha_nombramiento')
        ->first();

    return view('clientes.asignar-auditor', compact('cliente', 'auditorActual'));
}





    public function guardarAsignacionAuditor(Request $request, Cliente $cliente)
{
    $validated = $request->validate([
        'auditor_id' => 'required|exists:auditores,id',
        'fecha_nombramiento' => 'nullable|date',
        'fecha_fin_nombramiento' => 'nullable|date|after_or_equal:fecha_nombramiento',
        'activo' => 'boolean',
        'notas' => 'nullable|string|max:500',
    ]);

    $cliente->asignarNombramiento('auditores', $validated['auditor_id'], [
        'fecha_nombramiento' => $validated['fecha_nombramiento'] ?? now(),
        'fecha_fin_nombramiento' => $validated['fecha_fin_nombramiento'] ?? null,
        'notas' => $validated['notas'] ?? null,
    ]);

    return redirect()->route('clientes.index')->with('success', 'Auditor asignado correctamente.');
}



    public function index(): View
{
    $clientes = Cliente::with(['auditores', 'representantes'])
        ->orderByDesc('id')
        ->paginate(10);

    return view('clientes.index', compact('clientes'));
}


public function formAsignarRepresentante(Cliente $cliente)
{
    $representanteActual = $cliente->representantes()
        ->wherePivot('activo', true)
        ->orderByDesc('fecha_nombramiento')
        ->first();

    return view('clientes.asignar-representante', compact('cliente', 'representanteActual'));
}

public function guardarAsignacionRepresentante(Request $request, Cliente $cliente)
{
    $validated = $request->validate([
        'representante_id' => 'required|exists:representantes,id',
        'fecha_nombramiento' => 'nullable|date',
        'duracion_meses' => 'nullable|integer|min:1',
        'fecha_fin_nombramiento' => 'nullable|date|after_or_equal:fecha_nombramiento',
        'numero_acta' => 'nullable|string|max:100',
        'numero_acuerdo' => 'nullable|string|max:100',
        'activo' => 'boolean',
    ]);

    $cliente->asignarNombramiento('representantes', $validated['representante_id'], [
        'fecha_nombramiento' => $validated['fecha_nombramiento'] ?? now(),
        'duracion_meses' => $validated['duracion_meses'] ?? null,
        'fecha_fin_nombramiento' => $validated['fecha_fin_nombramiento'] ?? null,
        'numero_acta' => $validated['numero_acta'] ?? null,
        'numero_acuerdo' => $validated['numero_acuerdo'] ?? null,
    ]);

    return redirect()->route('clientes.index')->with('success', 'Representante asignado correctamente.');
}


public function show(Cliente $cliente)
{
    // Carga relaciones con pivotes
    $cliente->load([
        'auditores'     => fn($q) => $q->withPivot(
            'fecha_nombramiento',
            'fecha_fin_nombramiento',
            'activo',
            'notas'
        )->orderByDesc('pivot_fecha_nombramiento'),
        'representantes'=> fn($q) => $q->withPivot(
            'fecha_nombramiento',
            'duracion_meses',
            'fecha_fin_nombramiento',
            'numero_acta',
            'numero_acuerdo',
            'activo'
        )->orderByDesc('pivot_fecha_nombramiento'),
    ]);

    // Nombramiento vigente
    $auditorActual      = $cliente->auditores->first(fn($a) => $a->pivot->activo);
    $representanteActual= $cliente->representantes->first(fn($r) => $r->pivot->activo);

    return view('clientes.show', compact(
        'cliente',
        'auditorActual',
        'representanteActual'
    ));
}



}