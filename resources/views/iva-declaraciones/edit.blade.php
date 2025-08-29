@extends('layouts.app')

@section('title', 'Editar Declaración de IVA')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="rounded-md border p-6">
            <h2 class="text-2xl font-semibold mb-4">Editar Declaración de IVA</h2>
            <form action="{{ route('iva-declaraciones.update', $ivaDeclaracion->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                    <select name="cliente_id" id="cliente_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Seleccione un cliente</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ (old('cliente_id', $ivaDeclaracion->cliente_id) == $cliente->id) ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="periodo_inicio" class="block text-sm font-medium text-gray-700">Inicio del Período</label>
                        <input type="date" name="periodo_inicio" id="periodo_inicio" value="{{ old('periodo_inicio', $ivaDeclaracion->periodo_inicio) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('periodo_inicio')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="periodo_fin" class="block text-sm font-medium text-gray-700">Fin del Período</label>
                        <input type="date" name="periodo_fin" id="periodo_fin" value="{{ old('periodo_fin', $ivaDeclaracion->periodo_fin) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('periodo_fin')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="fecha_presentacion" class="block text-sm font-medium text-gray-700">Fecha de Presentación</label>
                    <input type="date" name="fecha_presentacion" id="fecha_presentacion" value="{{ old('fecha_presentacion', $ivaDeclaracion->fecha_presentacion) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('fecha_presentacion')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="monto_a_pagar" class="block text-sm font-medium text-gray-700">Monto a Pagar</label>
                    <input type="number" name="monto_a_pagar" id="monto_a_pagar" value="{{ old('monto_a_pagar', $ivaDeclaracion->monto_a_pagar) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('monto_a_pagar')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="plazo" id="plazo" value="1" {{ old('plazo', $ivaDeclaracion->plazo) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <label for="plazo" class="text-sm font-medium text-gray-700">¿Aplica plazo?</label>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="cantidad_cuotas" class="block text-sm font-medium text-gray-700">Cantidad de Cuotas</label>
                        <input type="number" name="cantidad_cuotas" id="cantidad_cuotas" value="{{ old('cantidad_cuotas', $ivaDeclaracion->cantidad_cuotas) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('cantidad_cuotas')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="dia_pago" class="block text-sm font-medium text-gray-700">Día de Pago</label>
                        <input type="number" name="dia_pago" id="dia_pago" value="{{ old('dia_pago', $ivaDeclaracion->dia_pago) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('dia_pago')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
