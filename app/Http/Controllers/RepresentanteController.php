<?php

namespace App\Http\Controllers;

use App\Models\Representante;
use App\Http\Requests\StoreRepresentanteRequest;
use App\Http\Requests\UpdateRepresentanteRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;        // ← Asegúrate de tener esto
use Illuminate\Http\JsonResponse;   // opcional, si quieres tipar el return


class RepresentanteController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Representante::class, 'representante');
    }

    public function index(): View
    {
        $representantes = Representante::orderByDesc('id')->paginate(10);
        return view('representantes.index', compact('representantes'));
    }

    public function create(): View
    {
        return view('representantes.create');
    }

    public function store(StoreRepresentanteRequest $request): RedirectResponse
    {
        Representante::create($request->validated());

        return redirect()
            ->route('representantes.index')
            ->with('success', 'Representante creado correctamente.');
    }

    public function show(Representante $representante): View
    {
        return view('representantes.show', compact('representante'));
    }

    public function edit(Representante $representante): View
    {
        return view('representantes.edit', compact('representante'));
    }

    public function update(UpdateRepresentanteRequest $request, Representante $representante): RedirectResponse
    {
        $representante->update($request->validated());

        return redirect()
            ->route('representantes.index')
            ->with('success', 'Representante actualizado correctamente.');
    }

    public function destroy(Representante $representante): RedirectResponse
    {
        $representante->delete();

        return redirect()
            ->route('representantes.index')
            ->with('success', 'Representante eliminado correctamente.');
    }

    public function search(Request $request)
{
    $term = $request->get('q', '');
    $representantes = Representante::where('nombre', 'like', "%{$term}%")
        ->orderBy('nombre')
        ->limit(10)
        ->get(['id', 'nombre']);

    return response()->json($representantes);
}

public function modalStore(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:200',
        'telefono' => 'nullable|string|max:50',
        'correo_electronico' => 'nullable|email|max:200',
    ]);

    $representante = Representante::create($validated);

    return response()->json($representante);
}

}