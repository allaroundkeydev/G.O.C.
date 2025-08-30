<?php

namespace App\Http\Controllers;

use App\Models\Auditor;
use App\Http\Requests\StoreAuditorRequest;
use App\Http\Requests\UpdateAuditorRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuditorController extends Controller
{
public function __construct()
{
    $this->authorizeResource(Auditor::class, 'auditor', [
        'except' => ['search', 'modalStore']
    ]);
}





    public function index(): View
    {
        $auditores = Auditor::orderByDesc('id')->paginate(10);
        return view('auditores.index', compact('auditores'));
    }

    public function create(): View
    {
        return view('auditores.create');
    }

    public function store(StoreAuditorRequest $request): RedirectResponse
    {
        Auditor::create($request->validated());

        return redirect()
            ->route('auditores.index')
            ->with('success', 'Auditor creado correctamente.');
    }

    public function show(Auditor $auditor): View
    {
        return view('auditores.show', compact('auditor'));
    }

    public function edit(Auditor $auditor): View
    {
        return view('auditores.edit', compact('auditor'));
    }

    public function update(UpdateAuditorRequest $request, Auditor $auditor): RedirectResponse
    {
        $auditor->update($request->validated());

        return redirect()
            ->route('auditores.index')
            ->with('success', 'Auditor actualizado correctamente.');
    }

    public function destroy(Auditor $auditor): RedirectResponse
    {
        $auditor->delete();

        return redirect()
            ->route('auditores.index')
            ->with('success', 'Auditor eliminado correctamente.');
    }

    public function search(Request $request)
    {
        $term = $request->get('q', '');
        $auditores = Auditor::where('nombre', 'like', "%{$term}%")
            ->orderBy('nombre')
            ->limit(10)
            ->get(['id', 'nombre']);

        return response()->json($auditores);
    }


public function modalStore(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:200',
        'telefono' => 'nullable|string|max:50',
        'correo_electronico' => 'nullable|email|max:200',
        'empresa' => 'nullable|string|max:200',
        'num_vpcpa' => 'nullable|string|max:100',
        'nombrado' => 'boolean',
    ]);

    $auditor = Auditor::create($validated);

    return response()->json($auditor);
}


}


