<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-text dark:text-text-dark">
      {{ __('Asignar Auditor a ') . $cliente->razon_social }}
    </h2>
  </x-slot>

  <div
    x-data="asignarAuditor('{{ $auditorActual->nombre ?? '' }}', {{ $auditorActual->id ?? 'null' }})"
    class="py-8 bg-background dark:bg-background-dark"
  >
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('clientes.guardarAsignacionAuditor', $cliente) }}">
          @csrf

          <!-- Campo de búsqueda -->
          <div class="mb-4">
            <x-input-label for="auditor_search" :value="__('Buscar Auditor')" />
            <input
              type="text"
              id="auditor_search"
              x-model="query"
              @input.debounce.300ms="buscarAuditores"
              placeholder="Escriba el nombre del auditor..."
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
            <ul x-show="resultados.length" class="border mt-1 bg-white dark:bg-surface-dark rounded shadow">
              <template x-for="auditor in resultados" :key="auditor.id">
                <li
                  @click="seleccionarAuditor(auditor)"
                  class="p-2 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer"
                  x-text="auditor.nombre"
                ></li>
              </template>
              <li
                @click="abrirModal()"
                class="p-2 bg-green-100 hover:bg-green-200 cursor-pointer"
              >
                + Agregar nuevo auditor
              </li>
            </ul>
            <input type="hidden" name="auditor_id" :value="auditorSeleccionado?.id">
          </div>

          <!-- Campos extra -->
          <div class="mb-4">
            <x-input-label for="fecha_nombramiento" :value="__('Fecha Nombramiento')" />
            <input
              type="date"
              name="fecha_nombramiento"
              value="{{ $auditorActual->pivot->fecha_nombramiento ?? '' }}"
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
          </div>

          <div class="mb-4">
            <x-input-label for="fecha_fin_nombramiento" :value="__('Fecha Fin Nombramiento')" />
            <input
              type="date"
              name="fecha_fin_nombramiento"
              value="{{ $auditorActual->pivot->fecha_fin_nombramiento ?? '' }}"
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
          </div>

          <div class="mb-4">
            <x-input-label for="notas" :value="__('Notas')" />
            <textarea
              name="notas"
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            >{{ $auditorActual->pivot->notas ?? '' }}</textarea>
          </div>

          <label class="inline-flex items-center mb-4">
            <input
              type="checkbox"
              name="activo"
              value="1"
              {{ ($auditorActual->pivot->activo ?? true) ? 'checked' : '' }}
              class="rounded border-border dark:border-border-dark text-primary"
            >
            <span class="ml-2">Activo</span>
          </label>

          <div class="flex justify-end">
            <x-primary-button>Guardar Asignación</x-primary-button>
          </div>
        </form>

        <!-- Bloque de nombramiento vigente -->
        @if($auditorActual)
          <div class="mt-6 p-4 border border-border dark:border-border-dark rounded bg-surface/50">
            <h4 class="font-semibold text-text dark:text-text-dark mb-2">Nombramiento vigente</h4>
            <ul class="text-sm text-text dark:text-text-dark space-y-1">
              <li><strong>Auditor:</strong> {{ $auditorActual->nombre }}</li>
              <li><strong>Fecha nombramiento:</strong> {{ $auditorActual->pivot->fecha_nombramiento ?? '—' }}</li>
              <li><strong>Fecha fin:</strong> {{ $auditorActual->pivot->fecha_fin_nombramiento ?? '—' }}</li>
              <li><strong>Notas:</strong> {{ $auditorActual->pivot->notas ?? '—' }}</li>
              <li><strong>Activo:</strong> {{ ($auditorActual->pivot->activo ?? false) ? 'Sí' : 'No' }}</li>
            </ul>
          </div>
        @endif
      </div>
    </div>

    <!-- Modal para crear auditor -->
    <div x-show="modalAbierto" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white dark:bg-surface-dark p-6 rounded-lg shadow max-w-lg w-full">
        <h3 class="text-lg font-semibold mb-4">Nuevo Auditor</h3>
        <form @submit.prevent="guardarAuditor">
          <div class="mb-4">
            <x-input-label for="nombre" :value="__('Nombre')" />
            <input
              type="text"
              x-model="nuevoAuditor.nombre"
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
          </div>
          <div class="mb-4">
            <x-input-label for="empresa" :value="__('Empresa')" />
            <input
              type="text"
              x-model="nuevoAuditor.empresa"
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
          </div>
          <div class="flex justify-end">
            <x-secondary-button @click="cerrarModal">Cancelar</x-secondary-button>
            <x-primary-button class="ml-2" type="submit">Guardar</x-primary-button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function asignarAuditor(nombreInicial = '', idInicial = null) {
      return {
        query: nombreInicial,
        resultados: [],
        auditorSeleccionado: idInicial ? { id: idInicial, nombre: nombreInicial } : null,
        modalAbierto: false,
        nuevoAuditor: { nombre: '', empresa: '' },

        buscarAuditores() {
          if (this.query.length < 2) { this.resultados = []; return; }
          fetch(`{{ route('auditores.search') }}?q=${encodeURIComponent(this.query)}`)
            .then(res => res.json())
            .then(data => this.resultados = data);
        },

        seleccionarAuditor(auditor) {
          this.auditorSeleccionado = auditor;
          this.query = auditor.nombre;
          this.resultados = [];
        },

        abrirModal() { this.modalAbierto = true; },

        cerrarModal() {
          this.modalAbierto = false;
          this.nuevoAuditor = { nombre: '', empresa: '' };
        },

        guardarAuditor() {
          fetch(`{{ route('auditores.modalStore') }}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(this.nuevoAuditor)
          })
          .then(res => {
            if (!res.ok) throw new Error('Error al guardar el auditor');
            return res.json();
          })
          .then(auditor => {
            this.auditorSeleccionado = auditor;
            this.query = auditor.nombre;
            this.resultados = [];
            this.cerrarModal();
          })
          .catch(err => {
            alert('Hubo un problema al guardar el auditor');
            console.error(err);
          });
        }
      }
    }
  </script>
</x-app-layout>