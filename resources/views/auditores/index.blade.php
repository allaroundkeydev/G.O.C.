<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-text dark:text-text-dark">
      {{ __('Listado de Auditores') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-background dark:bg-background-dark">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="flex justify-end mb-4">
        <a href="{{ route('auditores.create') }}"
           class="px-4 py-2 bg-primary text-primary-contrast rounded hover:bg-primary/90">
          {{ __('Nuevo Auditor') }}
        </a>
      </div>

      @if(session('success'))
        <div class="mb-4 p-4 bg-success/10 text-success rounded">
          {{ session('success') }}
        </div>
      @endif

      <div class="overflow-x-auto bg-surface dark:bg-surface-dark shadow-sm sm:rounded-lg">
        <table class="min-w-full table-auto">
          <thead class="bg-border dark:bg-border-dark">
            <tr>
              <th class="px-4 py-2 text-left">Nombre</th>
              <th class="px-4 py-2 text-left">Empresa</th>
              <th class="px-4 py-2 text-left">VPCPA</th>
              <th class="px-4 py-2 text-left">Nombrado</th>
              <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($auditores as $a)
              <tr class="border-t border-border dark:border-border-dark">
                <td class="px-4 py-2">{{ $a->nombre }}</td>
                <td class="px-4 py-2">{{ $a->empresa }}</td>
                <td class="px-4 py-2">{{ $a->num_vpcpa }}</td>
                <td class="px-4 py-2">
                  {{ $a->nombrado ? 'Sí' : 'No' }}
                </td>
                <td class="px-4 py-2 flex space-x-2 justify-center">
                  <a href="{{ route('auditores.edit', $a) }}"
                     class="px-2 py-1 bg-secondary text-secondary-contrast rounded hover:bg-secondary/90">
                    Editar
                  </a>
                  <form action="{{ route('auditores.destroy', $a) }}" method="POST"
                        onsubmit="return confirm('¿Eliminar este auditor?')">
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
          {{ $auditores->links() }}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>