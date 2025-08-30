<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-text dark:text-text-dark">
      {{ __('Asignar Representante a ') . $cliente->razon_social }}
    </h2>
  </x-slot>

  <div
    x-data="asignarRepresentante('{{ $representanteActual->nombre ?? '' }}', {{ $representanteActual->id ?? 'null' }})"
    class="py-8 bg-background dark:bg-background-dark"
  >
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('clientes.guardarAsignacionRepresentante', $cliente) }}">
          @csrf

          <!-- Campo de búsqueda -->
          <div class="mb-4">
            <x-input-label for="representante_search" :value="__('Buscar Representante')" />
            <input
              type="text"
              id="representante_search"
              x-model="query"
              @input.debounce.300ms="buscarRepresentantes"
              placeholder="Escriba el nombre del representante..."
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
            <ul x-show="resultados.length" class="border mt-1 bg-white dark:bg-surface-dark rounded shadow">
              <template x-for="rep in resultados" :key="rep.id">
                <li
                  @click="seleccionarRepresentante(rep)"
                  class="p-2 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer"
                  x-text="rep.nombre"
                ></li>
              </template>
              <li
                @click="abrirModal()"
                class="p-2 bg-green-100 hover:bg-green-200 cursor-pointer"
              >
                + Agregar nuevo representante
              </li>
            </ul>
            <input type="hidden" name="representante_id" :value="representanteSeleccionado?.id">
          </div>

          <!-- Campos extra -->
          <div class="mb-4">
            <x-input-label for="fecha_nombramiento" :value="__('Fecha Nombramiento')" />
            <input
              type="date"
              name="fecha_nombramiento"
              value="{{ $representanteActual->pivot->fecha_nombramiento ?? '' }}"
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
          </div>

          <div class="mb-4">
            <x-input-label for="duracion_meses" :value="__('Duración (meses)')" />
            <input
              type="number"
              name="duracion_meses"
              value="{{ $representanteActual->pivot->duracion_meses ?? '' }}"
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
          </div>

          <div class="mb-4">
            <x-input-label for="fecha_fin_nombramiento" :value="__('Fecha Fin Nombramiento')" />
            <input
              type="date"
              name="fecha_fin_nombramiento"
              value="{{ $representanteActual->pivot->fecha_fin_nombramiento ?? '' }}"
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
          </div>

          <div class="mb-4">
            <x-input-label for="numero_acta" :value="__('Número Acta')" />
            <input
              type="text"
              name="numero_acta"
              value="{{ $representanteActual->pivot->numero_acta ?? '' }}"
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
          </div>

          <div class="mb-4">
            <x-input-label for="numero_acuerdo" :value="__('Número Acuerdo')" />
            <input
              type="text"
              name="numero_acuerdo"
              value="{{ $representanteActual->pivot->numero_acuerdo ?? '' }}"
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
          </div>

          <label class="inline-flex items-center mb-4">
            <input
              type="checkbox"
              name="activo"
              value="1"
              {{ ($representanteActual->pivot->activo ?? true) ? 'checked' : '' }}
              class="rounded border-border dark:border-border-dark text-primary"
            >
            <span class="ml-2">Activo</span>
          </label>

          <div class="flex justify-end">
            <x-primary-button>Guardar Asignación</x-primary-button>
          </div>
        </form>

        <!-- Bloque de nombramiento vigente -->
        @if($representanteActual)
          <div class="mt-6 p-4 border border-border dark:border-border-dark rounded bg-surface/50">
            <h4 class="font-semibold text-text dark:text-text-dark mb-2">Nombramiento vigente</h4>
            <ul class="text-sm text-text dark:text-text-dark space-y-1">
              <li><strong>Representante:</strong> {{ $representanteActual->nombre }}</li>
              <li><strong>Fecha nombramiento:</strong> {{ $representanteActual->pivot->fecha_nombramiento ?? '—' }}</li>
              <li><strong>Duración:</strong> {{ $representanteActual->pivot->duracion_meses ?? '—' }} meses</li>
              <li><strong>Fecha fin:</strong> {{ $representanteActual->pivot->fecha_fin_nombramiento ?? '—' }}</li>
              <li><strong>Acta:</strong> {{ $representanteActual->pivot->numero_acta ?? '—' }}</li>
              <li><strong>Acuerdo:</strong> {{ $representanteActual->pivot->numero_acuerdo ?? '—' }}</li>
              <li><strong>Activo:</strong> {{ ($representanteActual->pivot->activo ?? false) ? 'Sí' : 'No' }}</li>
            </ul>
          </div>
        @endif
      </div>
    </div>

    <!-- Modal para crear representante -->
    <div x-show="modalAbierto" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white dark:bg-surface-dark p-6 rounded-lg shadow max-w-lg w-full">
        <h3 class="text-lg font-semibold mb-4">Nuevo Representante</h3>
        <form @submit.prevent="guardarRepresentante">
          <div class="mb-4">
            <x-input-label for="nombre" :value="__('Nombre')" />
            <input
              type="text"
              x-model="nuevoRepresentante.nombre"
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
          </div>
          <div class="mb-4">
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <input
              type="text"
              x-model="nuevoRepresentante.telefono"
              class="block mt-1 w-full border border-border dark:border-border-dark rounded"
            />
          </div>
          <div class="mb-4">
            <x-input-label for="correo_electronico" :value="__('Correo Electrónico')" />
            <input
              type="email"
              x-model="nuevoRepresentante.correo_electronico"
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
    function asignarRepresentante(nombreInicial = '', idInicial = null) {
      return {
        query: nombreInicial,
        resultados: [],
        representanteSeleccionado: idInicial ? { id: idInicial, nombre: nombreInicial } : null,
        modalAbierto: false,
        nuevoRepresentante: { nombre: '', telefono: '', correo_electronico: '' },

        buscarRepresentantes() {
          if (this.query.length < 2) { this.resultados = []; return; }
          fetch(`{{ route('representantes.search') }}?q=${encodeURIComponent(this.query)}`)
            .then(res => res.json())
            .then(data => this.resultados = data);
        },

        seleccionarRepresentante(rep) {
          this.representanteSeleccionado = rep;
          this.query = rep.nombre;
          this.resultados = [];
        },

        abrirModal() { this.modalAbierto = true; },

        cerrarModal() {
          this.modalAbierto = false;
          this.nuevoRepresentante = { nombre: '', telefono: '', correo_electronico: '' };
        },

        guardarRepresentante() {
          fetch(`{{ route('representantes.modalStore') }}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(this.nuevoRepresentante)
          })
          .then(res => {
            if (!res.ok) throw new Error('Error al guardar el representante');
            return res.json();
          })
          .then(rep => {
            this.representanteSeleccionado = rep;
            this.query = rep.nombre;
            this.resultados = [];
            this.cerrarModal();
          })
          .catch(err => {
            alert('Hubo un problema al guardar el representante');
            console.error(err);
          });
        }
      }
    }
  </script>
</x-app-layout>