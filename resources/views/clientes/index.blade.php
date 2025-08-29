<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-text dark:text-text-dark">
      {{ __('Listado de Clientes') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-background dark:bg-background-dark">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="flex justify-end mb-4">
        <a href="{{ route('clientes.create') }}"
           class="px-4 py-2 bg-primary text-primary-contrast rounded hover:bg-primary/90">
          {{ __('Nuevo Cliente') }}
        </a>
      </div>

      @if(session('success'))
        <div class="mb-4 p-4 bg-success/10 text-success rounded">
          {{ session('success') }}
        </div>
      @endif

      <div class="overflow-x-auto bg-surface dark:bg-surface-dark
                  shadow-sm sm:rounded-lg">
        <table class="min-w-full table-auto">
          <thead class="bg-border dark:bg-border-dark">
            <tr>
              <th class="px-4 py-2 text-left">ID</th>
              <th class="px-4 py-2 text-left">Razón Social</th>
              <th class="px-4 py-2 text-left">DUI</th>
              <th class="px-4 py-2 text-left">NIT</th>
              <th class="px-4 py-2 text-left">Tipo Gov.</th>
              <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($clientes as $c)
              <tr class="border-t border-border dark:border-border-dark">
                <td class="px-4 py-2">{{ $c->id }}</td>
                <td class="px-4 py-2">{{ $c->razon_social }}</td>
                <td class="px-4 py-2">{{ $c->dui }}</td>
                <td class="px-4 py-2">{{ $c->nit }}</td>
                <td class="px-4 py-2">{{ $c->tipo_gobierno }}</td>
                <td class="px-4 py-2 flex space-x-2 justify-center">
                  <a href="{{ route('clientes.edit', $c) }}"
                     class="px-2 py-1 bg-secondary text-secondary-contrast
                            rounded hover:bg-secondary/90">
                    {{ __('Editar') }}
                  </a>
                  <form action="{{ route('clientes.destroy', $c) }}"
                        method="POST"
                        onsubmit="return confirm('¿Eliminar este cliente?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-2 py-1 bg-error text-primary-contrast
                                   rounded hover:bg-error/90">
                      {{ __('Eliminar') }}
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