<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-text dark:text-text-dark">
      Detalle de Cliente: {{ $cliente->razon_social }}
    </h2>
  </x-slot>

  <div class="py-8 bg-background dark:bg-background-dark">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

      <!-- Datos Generales -->
      <div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-text dark:text-text-dark">Datos Generales</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-text dark:text-text-dark">
          <div>
            <strong>Razón Social:</strong><br>
            {{ $cliente->razon_social }}
          </div>
          <div>
            <strong>NIT:</strong><br>
            {{ $cliente->nit }}
          </div>
          <div>
            <strong>Dirección:</strong><br>
            {{ $cliente->direccion ?? '—' }}
          </div>
          <div>
            <strong>Teléfono:</strong><br>
            {{ $cliente->telefono ?? '—' }}
          </div>
        </div>
      </div>

      <!-- Auditor actual -->
<div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow">
  <h3 class="text-lg font-semibold text-text dark:text-text-dark">Auditor Vigente</h3>
  @if($auditorActual)
    <ul class="mt-4 text-sm text-text dark:text-text-dark space-y-1">
      <li>
        <strong>Auditor:</strong>
        {{ $auditorActual->nombre }}
      </li>
      <li>
        <strong>Nombramiento:</strong>
        {{ $auditorActual->pivot->fecha_nombramiento?->format('d/m/Y') ?? '—' }}
      </li>
      <li>
        <strong>Vence:</strong>
        {{ $auditorActual->pivot->fecha_fin_nombramiento?->format('d/m/Y') ?? '—' }}
      </li>
      <li>
        <strong>Notas:</strong>
        {{ $auditorActual->pivot->notas ?? '—' }}
      </li>
    </ul>
  @else
    <p class="mt-4 text-sm text-gray-500">No hay auditor asignado actualmente.</p>
  @endif
</div>

<!-- Representante actual -->
<div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow">
  <h3 class="text-lg font-semibold text-text dark:text-text-dark">Representante Vigente</h3>
  @if($representanteActual)
    <ul class="mt-4 text-sm text-text dark:text-text-dark space-y-1">
      <li>
        <strong>Nombre:</strong>
        {{ $representanteActual->nombre }}
      </li>
      <li>
        <strong>Nombramiento:</strong>
        {{ $representanteActual->pivot->fecha_nombramiento?->format('d/m/Y') ?? '—' }}
      </li>
      <li>
        <strong>Duración:</strong>
        {{ $representanteActual->pivot->duracion_meses ?? '—' }} meses
      </li>
      <li>
        <strong>Vence:</strong>
        {{ $representanteActual->pivot->fecha_fin_nombramiento?->format('d/m/Y') ?? '—' }}
      </li>
      <li>
        <strong>Acta:</strong>
        {{ $representanteActual->pivot->numero_acta ?? '—' }}
      </li>
      <li>
        <strong>Acuerdo:</strong>
        {{ $representanteActual->pivot->numero_acuerdo ?? '—' }}
      </li>
    </ul>
  @else
    <p class="mt-4 text-sm text-gray-500">No hay representante asignado actualmente.</p>
  @endif
</div>

<!-- Historial de Nombramientos -->
<div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow">
  <h3 class="text-lg font-semibold text-text dark:text-text-dark">Historial de Nombramientos</h3>

  <!-- Auditores -->
  <h4 class="mt-4 font-medium text-text dark:text-text-dark">Auditores</h4>
  <table class="w-full mt-2 text-sm text-text dark:text-text-dark">
    <thead>
      <tr class="border-b">
        <th class="px-2 py-1 text-left">Auditor</th>
        <th class="px-2 py-1">Nombramiento</th>
        <th class="px-2 py-1">Vence</th>
        <th class="px-2 py-1">Activo</th>
      </tr>
    </thead>
    <tbody>
      @foreach($cliente->auditores as $aud)
        <tr class="border-b last:border-0">
          <td class="px-2 py-1">{{ $aud->nombre }}</td>
          <td class="px-2 py-1">{{ $aud->pivot->fecha_nombramiento?->format('d/m/Y') ?? '—' }}</td>
          <td class="px-2 py-1">{{ $aud->pivot->fecha_fin_nombramiento?->format('d/m/Y') ?? '—' }}</td>
          <td class="px-2 py-1">{{ $aud->pivot->activo ? 'Sí' : 'No' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Representantes -->
  <h4 class="mt-6 font-medium text-text dark:text-text-dark">Representantes</h4>
  <table class="w-full mt-2 text-sm text-text dark:text-text-dark">
    <thead>
      <tr class="border-b">
        <th class="px-2 py-1 text-left">Representante</th>
        <th class="px-2 py-1">Nombramiento</th>
        <th class="px-2 py-1">Vence</th>
        <th class="px-2 py-1">Activo</th>
      </tr>
    </thead>
    <tbody>
      @foreach($cliente->representantes as $rep)
        <tr class="border-b last:border-0">
          <td class="px-2 py-1">{{ $rep->nombre }}</td>
          <td class="px-2 py-1">{{ $rep->pivot->fecha_nombramiento?->format('d/m/Y') ?? '—' }}</td>
          <td class="px-2 py-1">{{ $rep->pivot->fecha_fin_nombramiento?->format('d/m/Y') ?? '—' }}</td>
          <td class="px-2 py-1">{{ $rep->pivot->activo ? 'Sí' : 'No' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

      <!-- Botones finales -->
      <div class="flex justify-end space-x-2">
        <a href="{{ route('clientes.edit', $cliente) }}"
           class="inline-flex items-center px-4 py-2 bg-secondary text-secondary-contrast rounded hover:bg-secondary/90">
          Editar
        </a>
        <a href="{{ route('clientes.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
          Volver
        </a>
      </div>
    </div>
  </div>
</x-app-layout>