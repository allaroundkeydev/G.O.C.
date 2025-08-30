<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-text dark:text-text-dark">
      {{ __('Listado de Representantes') }}
    </h2>
  </x-slot>

  <div x-data="{ openModal: false, modalData: {} }" class="py-8 bg-background dark:bg-background-dark">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="flex justify-end mb-4">
        <a href="{{ route('representantes.create') }}"
           class="px-4 py-2 bg-primary text-primary-contrast rounded hover:bg-primary/90">
          {{ __('Nuevo Representante') }}
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
              <th class="px-4 py-2 text-left">DUI</th>
              <th class="px-4 py-2 text-left">Teléfono</th>
              <th class="px-4 py-2 text-left">Correo</th>
              <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($representantes as $r)
              <tr class="border-t border-border dark:border-border-dark">
                <td class="px-4 py-2">{{ $r->nombre }}</td>
                <td class="px-4 py-2">{{ $r->dui }}</td>
                <td class="px-4 py-2">{{ $r->telefono }}</td>
                <td class="px-4 py-2">{{ $r->correo_electronico }}</td>
                <td class="px-4 py-2 flex space-x-2 justify-center">
                  <!-- Botón para abrir el modal -->
                  <button
                      @click="openModal = true; modalData = {{ Js::from($r) }}"
                      class="px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Ver
                  </button>

                  <a href="{{ route('representantes.edit', $r) }}"
                     class="px-2 py-1 bg-secondary text-secondary-contrast rounded hover:bg-secondary/90">
                    Editar
                  </a>

                  <form action="{{ route('representantes.destroy', $r) }}" method="POST"
                        onsubmit="return confirm('¿Eliminar este representante?')">
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
          {{ $representantes->links() }}
        </div>
      </div>
    </div>

    <!-- Modal único -->
    <div x-show="openModal" x-transition
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
         style="display: none;">
      <div class="bg-white dark:bg-surface-dark rounded-lg shadow-lg max-w-3xl w-full p-8 relative">
        <!-- Cerrar -->
        <button @click="openModal = false"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl font-bold">
          &times;
        </button>

        <h3 class="text-lg font-semibold mb-4 text-text dark:text-text-dark">
          Detalles de <span x-text="modalData.nombre"></span>
        </h3>

        <div class="space-y-3 text-lg text-text dark:text-text-dark leading-relaxed">
          <p><strong>DUI:</strong> <span x-text="modalData.dui"></span></p>
          <p><strong>Teléfono:</strong> <span x-text="modalData.telefono"></span></p>
          <p><strong>Correo:</strong> <span x-text="modalData.correo_electronico"></span></p>
          <p><strong>Fecha de Nacimiento:</strong> <span x-text="modalData.fecha_nacimiento"></span></p>
          <p><strong>Fecha de Nombramiento:</strong> <span x-text="modalData.fecha_nombramiento"></span></p>
          <p><strong>Duración:</strong> <span x-text="modalData.duracion_meses"></span> meses</p>
          <p><strong>Fecha Fin:</strong> <span x-text="modalData.fecha_fin_nombramiento"></span></p>
          <p><strong>Acta:</strong> <span x-text="modalData.numero_acta"></span></p>
          <p><strong>Acuerdo:</strong> <span x-text="modalData.numero_acuerdo"></span></p>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>