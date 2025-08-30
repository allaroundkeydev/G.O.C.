<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-text dark:text-text-dark">
      {{ __('Detalle del Representante') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-background dark:bg-background-dark">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow space-y-4">
        <p><strong>Nombre:</strong> {{ $representante->nombre }}</p>
        <p><strong>DUI:</strong> {{ $representante->dui }}</p>
        <p><strong>Teléfono:</strong> {{ $representante->telefono }}</p>
        <p><strong>Correo:</strong> {{ $representante->correo_electronico }}</p>
        <p><strong>Fecha de Nacimiento:</strong> {{ $representante->fecha_nacimiento?->format('d/m/Y') }}</p>
        <p><strong>Fecha de Nombramiento:</strong> {{ $representante->fecha_nombramiento?->format('d/m/Y') }}</p>
        <p><strong>Duración:</strong> {{ $representante->duracion_meses }} meses</p>
        <p><strong>Fecha Fin:</strong> {{ $representante->fecha_fin_nombramiento?->format('d/m/Y') }}</p>
        <p><strong>Acta:</strong> {{ $representante->numero_acta }}</p>
        <p><strong>Acuerdo:</strong> {{ $representante->numero_acuerdo }}</p>
      </div>
    </div>
  </div>
</x-app-layout>