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

                <td class="px-4 py-2 flex flex-wrap gap-2 justify-center">

  <!-- Asignar / confirmar Auditor -->
  <a href="{{ route('clientes.asignarAuditor', $cliente) }}"
     title="Asignar o confirmar auditor"
     aria-label="Asignar o confirmar auditor"
     class="inline-flex items-center p-1 text-white bg-indigo-600 hover:bg-indigo-700 rounded">
    <x-heroicon-o-user-group class="h-5 w-5" />
    <span class="ml-1 text-sm">Aud.</span>
  </a>

  <!-- Asignar / confirmar Representante -->
  <a href="{{ route('clientes.asignarRepresentante', $cliente) }}"
     title="Asignar o confirmar representante"
     aria-label="Asignar o confirmar representante"
     class="inline-flex items-center p-1 text-black bg-yellow-400 hover:bg-yellow-500 rounded">
    <x-heroicon-o-user-circle class="h-5 w-5" />
    <span class="ml-1 text-sm">Rep.</span>
  </a>

  <!-- Ver detalle del Cliente -->
  <a href="{{ route('clientes.show', $cliente) }}"
     title="Ver detalle del cliente"
     aria-label="Ver detalle del cliente"
     class="inline-flex items-center p-1 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded">
    <x-heroicon-o-eye class="h-5 w-5" />
    <span class="ml-1 text-sm">Ver</span>
  </a>

  <!-- Editar Cliente -->
  <a href="{{ route('clientes.edit', $cliente) }}"
     title="Editar cliente"
     aria-label="Editar cliente"
     class="inline-flex items-center p-1 bg-secondary text-secondary-contrast hover:bg-secondary/90 rounded">
    <x-heroicon-o-pencil class="h-5 w-5" />
    <span class="ml-1 text-sm">Edit</span>
  </a>

  <!-- Eliminar Cliente -->
  <form action="{{ route('clientes.destroy', $cliente) }}"
        method="POST"
        onsubmit="return confirm('¿Eliminar este cliente?')"
        class="inline-block">
    @csrf
    @method('DELETE')
    <button type="submit"
            title="Eliminar cliente"
            aria-label="Eliminar cliente"
            class="inline-flex items-center p-1 bg-error text-primary-contrast hover:bg-error/90 rounded">
      <x-heroicon-o-trash class="h-5 w-5" />
      <span class="ml-1 text-sm">Del</span>
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