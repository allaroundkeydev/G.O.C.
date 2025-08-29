<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-text dark:text-text-dark">
      {{ __('Editar Cliente') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-background dark:bg-background-dark">
    <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
      <div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow">
        <form action="{{ route('clientes.update', $cliente) }}" method="POST">
          @csrf
          @method('PUT')

          {{-- Repite los mismos campos de create usando old(..., $cliente->...) --}}
          {{-- Ejemplo Razón Social --}}
          <div class="mb-4">
            <x-input-label for="razon_social" :value="__('Razón Social')" />
            <x-text-input id="razon_social" name="razon_social" type="text"
                          value="{{ old('razon_social', $cliente->razon_social) }}"
                          class="block mt-1 w-full border border-border dark:border-border-dark" />
            <x-input-error :messages="$errors->get('razon_social')" class="mt-2 text-error"/>
          </div>

          <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
              <x-input-label for="dui" :value="__('DUI')" />
              <x-text-input id="dui" name="dui" type="text"
                            value="{{ old('dui', $cliente->dui) }}"
                            class="block mt-1 w-full border border-border dark:border-border-dark" />
              <x-input-error :messages="$errors->get('dui')" class="mt-2 text-error"/>
            </div>
            <div>
              <x-input-label for="nit" :value="__('NIT')" />
              <x-text-input id="nit" name="nit" type="text"
                            value="{{ old('nit', $cliente->nit) }}"
                            class="block mt-1 w-full border border-border dark:border-border-dark" />
              <x-input-error :messages="$errors->get('nit')" class="mt-2 text-error"/>
            </div>
          </div>

          <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
              <x-input-label for="fecha_constitucion" :value="__('Fecha Constitución')" />
              <x-text-input id="fecha_constitucion" name="fecha_constitucion" type="date"
                            value="{{ old('fecha_constitucion', $cliente->fecha_constitucion) }}"
                            class="block mt-1 w-full border border-border dark:border-border-dark" />
              <x-input-error :messages="$errors->get('fecha_constitucion')" class="mt-2 text-error"/>
            </div>
            <div>
              <x-input-label for="fecha_inscripcion" :value="__('Fecha Inscripción')" />
              <x-text-input id="fecha_inscripcion" name="fecha_inscripcion" type="date"
                            value="{{ old('fecha_inscripcion', $cliente->fecha_inscripcion) }}"
                            class="block mt-1 w-full border border-border dark:border-border-dark" />
              <x-input-error :messages="$errors->get('fecha_inscripcion')" class="mt-2 text-error"/>
            </div>
          </div>

          <div class="mb-6">
            <x-input-label for="tipo_gobierno" :value="__('Tipo de Gobierno')" />
            <x-text-input id="tipo_gobierno" name="tipo_gobierno" type="text"
                          value="{{ old('tipo_gobierno', $cliente->tipo_gobierno) }}"
                          class="block mt-1 w-full border border-border dark:border-border-dark" />
            <x-input-error :messages="$errors->get('tipo_gobierno')" class="mt-2 text-error"/>
          </div>

          <div class="flex justify-end">
            <x-primary-button>
              {{ __('Actualizar Cliente') }}
            </x-primary-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>