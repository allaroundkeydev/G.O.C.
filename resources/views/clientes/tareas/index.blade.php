<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-text dark:text-text-dark">
      Tareas de {{ $cliente->razon_social }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

      <!-- Botón Crear -->
      <div class="flex justify-end mb-4">
        <a href="{{ route('clientes.tareas.create', $cliente) }}"
           class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
          + Asignar Tarea
        </a>
      </div>

      <!-- Tabla de asignaciones -->
      <div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-text dark:text-text-dark">
          <thead>
            <tr class="border-b">
              <th class="px-2 py-1 text-left">Plantilla</th>
              <th class="px-2 py-1">Contador</th>
              <th class="px-2 py-1">Institución</th>
              <th class="px-2 py-1">Alerta (días)</th>
              <th class="px-2 py-1">Activo</th>
            </tr>
          </thead>
          <tbody>
            @foreach($asignaciones as $asig)
              <tr class="border-b last:border-0">
                <td class="px-2 py-1">{{ $asig->tarea->nombre }}</td>
                <td class="px-2 py-1">
                  {{ optional($asig->contador)->nombre_completo ?? '—' }}
                </td>
                <td class="px-2 py-1">
                  {{ optional($asig->institucion)->nombre ?? '—' }}
                </td>
                <td class="px-2 py-1">{{ $asig->alerta_dias_antes }}</td>
                <td class="px-2 py-1">
                  {{ $asig->activo ? 'Sí' : 'No' }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>
</x-app-layout>