<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-text dark:text-text-dark">
      {{ __('Listado de Clientes') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-background dark:bg-background-dark">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      @if(session('success'))
        <div class="mb-4 p-4 bg-success/10 text-success rounded">
          {{ session('success') }}
        </div>
      @endif

      <div class="overflow-x-auto bg-surface dark:bg-surface-dark shadow-sm sm:rounded-lg">
        <table class="min-w-full table-auto">
          <thead class="bg-border dark:bg-border-dark">
            <tr>
              <th class="px-4 py-2 text-left">Razón Social</th>
              <th class="px-4 py-2 text-left">Auditor</th>
              <th class="px-4 py-2 text-left">Representante</th>
              <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($clientes as $cliente)
              <tr class="border-t border-border dark:border-border-dark">
                <td class="px-4 py-2">{{ $cliente->razon_social }}</td>

                <!-- Auditor actual -->
                <td class="px-4 py-2">
                  @if($cliente->auditores->count())
                    {{ $cliente->auditores->first()->nombre }}
                  @else
                    <span class="text-muted">No asignado</span>
                  @endif
                </td>

                <!-- Representante actual -->
                <td class="px-4 py-2">
                  @if($cliente->representantes->count())
                    {{ $cliente->representantes->first()->nombre }}
                  @else
                    <span class="text-muted">No asignado</span>
                  @endif
                </td>

                <!-- Botones -->
                <td class="px-4 py-2 flex flex-wrap gap-2 justify-center">
                  <!-- Asignar/Cambiar Auditor -->
                  <a href="{{ route('clientes.asignarAuditor', $cliente) }}"
                     class="px-2 py-1 rounded text-white
                            {{ $cliente->auditores->count() ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                    {{ $cliente->auditores->count() ? 'Cambiar / Confirmar Auditor' : 'Asignar Auditor' }}
                  </a>

                  <!-- Asignar/Cambiar Representante -->
                  <a href="{{ route('clientes.asignarRepresentante', $cliente) }}"
                     class="px-2 py-1 rounded text-white
                            {{ $cliente->representantes->count() ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                    {{ $cliente->representantes->count() ? 'Cambiar / Confirmar Representante' : 'Asignar Representante' }}
                  </a>

                  <!-- Editar -->
                  <a href="{{ route('clientes.edit', $cliente) }}"
                     class="px-2 py-1 bg-secondary text-secondary-contrast rounded hover:bg-secondary/90">
                    Editar
                  </a>

                  <!-- Eliminar -->
                  <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                        onsubmit="return confirm('¿Eliminar este cliente?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-2 py-1 bg-error text-primary-contrast rounded hover:bg-error/90">
                      Eliminar
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="p-4">
          {{ $clientes->links() }}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>