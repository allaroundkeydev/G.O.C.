<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text dark:text-text-dark leading-tight">
            Listado de Usuarios
        </h2>
    </x-slot>

    <div class="py-8 bg-background dark:bg-background-dark">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('users.create') }}"
                   class="px-4 py-2 bg-primary text-primary-contrast rounded hover:bg-primary/90">
                    Nuevo Usuario
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
                            <th class="px-4 py-2 text-left text-text dark:text-text-dark">ID</th>
                            <th class="px-4 py-2 text-left text-text dark:text-text-dark">Nombre</th>
                            <th class="px-4 py-2 text-left text-text dark:text-text-dark">Usuario</th>
                            <th class="px-4 py-2 text-left text-text dark:text-text-dark">Email</th>
                            <th class="px-4 py-2 text-left text-text dark:text-text-dark">Rol</th>
                            <th class="px-4 py-2 text-left text-text dark:text-text-dark">Estado</th>
                            <th class="px-4 py-2 text-center text-text dark:text-text-dark">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                            <tr class="border-t border-border dark:border-border-dark">
                                <td class="px-4 py-2">{{ $u->id }}</td>
                                <td class="px-4 py-2">{{ $u->nombre_completo }}</td>
                                <td class="px-4 py-2">{{ $u->username }}</td>
                                <td class="px-4 py-2">{{ $u->email }}</td>
                                <td class="px-4 py-2">{{ ucfirst($u->rol) }}</td>
                                <td class="px-4 py-2">{{ $u->estado }}</td>
                                <td class="px-4 py-2 flex items-center justify-center space-x-2">
                                    <a href="{{ route('users.edit', $u) }}"
                                       class="px-2 py-1 bg-secondary text-secondary-contrast rounded hover:bg-secondary/90">
                                        Editar
                                    </a>

                                    <form action="{{ route('users.destroy', $u) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar este usuario?')">
                                        @csrf
                                        @method('DELETE')
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>