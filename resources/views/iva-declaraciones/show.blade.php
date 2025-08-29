@extends('layouts.app')

@section('title', 'Detalle de la Declaración')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="rounded-md border p-6">
            <h2 class="text-2xl font-semibold mb-4">Detalle de la Declaración</h2>
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium">Cliente</h3>
                    <p class="text-muted-foreground">{{ $ivaDeclaracion->cliente->nombre ?? 'N/A' }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-lg font-medium">Período de Inicio</h3>
                        <p class="text-muted-foreground">{{ $ivaDeclaracion->periodo_inicio }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium">Período de Fin</h3>
                        <p class="text-muted-foreground">{{ $ivaDeclaracion->periodo_fin }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-medium">Fecha de Presentación</h3>
                    <p class="text-muted-foreground">{{ $ivaDeclaracion->fecha_presentacion }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-medium">Monto a Pagar</h3>
                    <p class="text-muted-foreground">{{ $ivaDeclaracion->monto_a_pagar }}</p>
                </div>
                @if ($ivaDeclaracion->plazo)
                    <div>
                        <h3 class="text-lg font-medium">Cantidad de Cuotas</h3>
                        <p class="text-muted-foreground">{{ $ivaDeclaracion->cantidad_cuotas }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium">Día de Pago</h3>
                        <p class="text-muted-foreground">{{ $ivaDeclaracion->dia_pago }}</p>
                    </div>
                @endif
                <div class="flex justify-end">
                    <a href="{{ route('iva-declaraciones.index') }}">
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:bg-gray-50 disabled:opacity-25 transition ease-in-out duration-150">Volver</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
