@extends('layouts.app')

@section('title', 'Declaraciones de IVA')

@section('content')
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <form action="{{ route('iva-declaraciones.index') }}" method="GET" class="max-w-sm">
                <input
                    type="text"
                    name="search"
                    placeholder="Buscar por cliente..."
                    value="{{ request('search') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                />
            </form>
            <a href="{{ route('iva-declaraciones.create') }}">
                <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Nueva Declaración</button>
            </a>
        </div>
        <div class="rounded-md border">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Presentación</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto a Pagar</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($ivaDeclaraciones->data as $declaracion)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $declaracion->cliente->nombre ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $declaracion->periodo_inicio }} - {{ $declaracion->periodo_fin }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $declaracion->fecha_presentacion }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $declaracion->monto_a_pagar }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('iva-declaraciones.show', $declaracion->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                <a href="{{ route('iva-declaraciones.edit', $declaracion->id) }}" class="ml-4 text-indigo-600 hover:text-indigo-900">Editar</a>
                                <form action="{{ route('iva-declaraciones.destroy', $declaracion->id) }}" method="POST" class="inline-block ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar esta declaración?')" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $ivaDeclaraciones->links() }}
    </div>
@endsection
