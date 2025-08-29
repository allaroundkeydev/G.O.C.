<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text dark:text-text-dark leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-background dark:bg-background-dark">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nombre completo -->
                    <div class="mb-4">
                        <x-input-label for="nombre_completo" :value="__('Nombre completo')" />
                        <x-text-input
                            id="nombre_completo"
                            name="nombre_completo"
                            type="text"
                            value="{{ old('nombre_completo', $user->nombre_completo) }}"
                            class="block mt-1 w-full border border-border dark:border-border-dark"
                        />
                        <x-input-error :messages="$errors->get('nombre_completo')" class="mt-2 text-error" />
                    </div>

                    <!-- Usuario -->
                    <div class="mb-4">
                        <x-input-label for="username" :value="__('Usuario')" />
                        <x-text-input
                            id="username"
                            name="username"
                            type="text"
                            value="{{ old('username', $user->username) }}"
                            class="block mt-1 w-full border border-border dark:border-border-dark"
                        />
                        <x-input-error :messages="$errors->get('username')" class="mt-2 text-error" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email) }}"
                            class="block mt-1 w-full border border-border dark:border-border-dark"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-error" />
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-4">
                        <x-input-label for="telefono" :value="__('Teléfono')" />
                        <x-text-input
                            id="telefono"
                            name="telefono"
                            type="text"
                            value="{{ old('telefono', $user->telefono) }}"
                            class="block mt-1 w-full border border-border dark:border-border-dark"
                        />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-2 text-error" />
                    </div>

                    <!-- Nueva contraseña (opcional) -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Nueva contraseña')" />
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="{{ __('Dejar en blanco para no cambiar') }}"
                            class="block mt-1 w-full border border-border dark:border-border-dark"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-error" />
                    </div>

                    <!-- Rol -->
                    <div class="mb-4">
                        <x-input-label for="rol" :value="__('Rol')" />
                        <select
                            id="rol"
                            name="rol"
                            class="block mt-1 w-full border border-border dark:border-border-dark"
                        >
                            @foreach(['admin' => 'Administrador', 'contador' => 'Contador'] as $key => $label)
                                <option
                                    value="{{ $key }}"
                                    {{ old('rol', $user->rol) === $key ? 'selected' : '' }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('rol')" class="mt-2 text-error" />
                    </div>

                    <!-- Estado -->
                    <div class="mb-6">
                        <x-input-label for="estado" :value="__('Estado')" />
                        <select
                            id="estado"
                            name="estado"
                            class="block mt-1 w-full border border-border dark:border-border-dark"
                        >
                            @foreach(['ACTIVO' => 'Activo', 'INACTIVO' => 'Inactivo'] as $key => $label)
                                <option
                                    value="{{ $key }}"
                                    {{ old('estado', $user->estado) === $key ? 'selected' : '' }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('estado')" class="mt-2 text-error" />
                    </div>

                    <!-- Botón Actualizar -->
                    <div class="flex justify-end">
                        <x-primary-button>
                            {{ __('Actualizar usuario') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>