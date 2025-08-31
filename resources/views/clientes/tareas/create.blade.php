<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-text dark:text-text-dark">
      Asignar Tarea a {{ $cliente->razon_social }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow">
        <form method="POST"
              action="{{ route('clientes.tareas.store', $cliente) }}">
          @csrf

          <div class="mb-4">
            <x-input-label for="tarea_id" value="Plantilla de Tarea" />
            <select name="tarea_id"
                    class="block mt-1 w-full border rounded"
                    required>
              <option value="">Selecciona...</option>
              @foreach($plantillas as $id => $nombre)
                <option value="{{ $id }}">
                  {{ $nombre }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
              <x-input-label for="contador_id" value="Contador (opcional)" />
              <select name="contador_id" class="block mt-1 w-full border rounded">
                <option value="">— Ninguno —</option>
                @foreach($contadores as $id => $name)
                  <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <x-input-label for="institucion_id" value="Institución (opcional)" />
              <select name="institucion_id" class="block mt-1 w-full border rounded">
                <option value="">— Ninguna —</option>
                @foreach($instituciones as $id => $name)
                  <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
              <x-input-label for="alerta_dias_antes" value="Alerta (días antes)" />
              <input type="number" name="alerta_dias_antes" 
                     value="7"
                     class="block mt-1 w-full border rounded" />
            </div>
            <div class="flex items-center mt-6">
              <input type="checkbox" name="activo" value="1" checked
                     class="rounded border" id="activo"/>
              <label for="activo" class="ml-2">Activo</label>
            </div>
          </div>

          <div class="flex justify-end">
            <x-secondary-button href="{{ route('clientes.tareas.index', $cliente) }}">
              Cancelar
            </x-secondary-button>
            <x-primary-button class="ml-2">Guardar Asignación</x-primary-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>