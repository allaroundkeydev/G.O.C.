<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Tarea;
use App\Models\TareaCliente;
use App\Models\User;
use App\Models\Institucion;

use Illuminate\Http\Request;

class TareaClienteController extends Controller
{
    // 1. Listado de asignaciones de tareas para un cliente
    public function index(Cliente $cliente)
    {
        $asignaciones = $cliente
            ->tareasClientes()
            ->with(['tarea','contador','auditor','representante'])
            ->get();

        return view('clientes.tareas.index', compact('cliente','asignaciones'));
    }

    // 2. Formulario de nueva asignación
    public function create(Cliente $cliente)
    {
        $plantillas     = Tarea::pluck('nombre','id');
        $contadores     = User::where('rol','contador')
                              ->pluck('nombre_completo','id');
        $auditores = $cliente
        ->auditores()                // mantiene tu orderByDesc en la relación
        ->get()                      // carga la colección
        ->pluck('nombre','id');      // ahora 'id' siempre es auditores.id

    $representantes = $cliente
        ->representantes()
        ->get()
        ->pluck('nombre','id');
$instituciones = Institucion::pluck('nombre','id');


    return view('clientes.tareas.create', compact(
        'cliente','plantillas','contadores',
        'auditores','representantes','instituciones'
    ));
}


    // 3. Guardar nueva asignación
    public function store(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'tarea_id'           => 'required|exists:tareas,id',
            'contador_id'        => 'nullable|exists:users,id',
            'auditor_id'         => 'nullable|exists:auditores,id',
            'representante_id'   => 'nullable|exists:representantes,id',
            'institucion_id'     => 'nullable|exists:instituciones,id',
            'recurrence_rule'    => 'nullable|string',
            'alerta_dias_antes'  => 'required|integer|min:0',
            'activo'             => 'boolean',
        ]);

        $cliente->tareasClientes()->create(array_merge(
            $validated,
            ['activo' => $validated['activo'] ?? true]
        ));

        return redirect()
            ->route('clientes.tareas.index', $cliente)
            ->with('success','Tarea asignada correctamente.');
    }
}