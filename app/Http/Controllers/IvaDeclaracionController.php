<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIvaDeclaracionRequest;
use App\Http\Requests\UpdateIvaDeclaracionRequest;
use App\Models\Cliente;
use App\Models\IvaDeclaracion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IvaDeclaracionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(IvaDeclaracion::class, 'iva_declaracion');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ivaDeclaraciones = IvaDeclaracion::with('cliente')
            ->when($request->input('search'), function ($query, $search) {
                $query->whereHas('cliente', function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString();

        return view('iva-declaraciones.index', [
            'ivaDeclaraciones' => $ivaDeclaraciones,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('iva-declaraciones.create', [
            'clientes' => Cliente::all(['id', 'nombre']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIvaDeclaracionRequest $request)
    {
        $ivaDeclaracion = IvaDeclaracion::create($request->validated());
        return redirect()->route('iva-declaraciones.index')->with('success', 'Declaración de IVA creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IvaDeclaracion $ivaDeclaracion)
    {
        $ivaDeclaracion->load('cliente');
        return view('iva-declaraciones.show', [
            'ivaDeclaracion' => $ivaDeclaracion,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IvaDeclaracion $ivaDeclaracion)
    {
        return view('iva-declaraciones.edit', [
            'ivaDeclaracion' => $ivaDeclaracion,
            'clientes' => Cliente::all(['id', 'nombre']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIvaDeclaracionRequest $request, IvaDeclaracion $ivaDeclaracion)
    {
        $ivaDeclaracion->update($request->validated());
        return redirect()->route('iva-declaraciones.index')->with('success', 'Declaración de IVA actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IvaDeclaracion $ivaDeclaracion)
    {
        $ivaDeclaracion->delete();
        return redirect()->route('iva-declaraciones.index')->with('success', 'Declaración de IVA eliminada con éxito.');
    }
}