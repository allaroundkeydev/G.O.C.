<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text dark:text-text-dark leading-tight">
            Nuevo Usuario
        </h2>
    </x-slot>

    <div class="py-8 bg-background dark:bg-background-dark">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow">

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="nombre_completo" :value="__('Nombre completo')" />
                        <x-text-input id="nombre_completo" name="nombre_completo" type="text"
                                      value="{{ old('nombre_completo') }}"
                                      class="block mt-1 w-full border border-border dark:border-border-dark" />
                        <x-input-error :messages="$errors->get('nombre_completo')" class="mt-2 text-error"/>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="username" :value="__('Usuario')" />
                        <x-text-input id="username" name="username" type="text"
                                      value="{{ old('username') }}"
                                      class="block mt-1 w-full border border-border dark:border-border-dark" />
                        <x-input-error :messages="$errors->get('username')" class="mt-2 text-error"/>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email"
                                      value="{{ old('email') }}"
                                      class="block mt-1 w-full border border-border dark:border-border-dark" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-error"/>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="telefono" :value="__('Teléfono')" />
                        <x-text-input id="telefono" name="telefono" type="text"
                                      value="{{ old('telefono') }}"
                                      class="block mt-1 w-full border border-border dark:border-border-dark" />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-2 text-error"/>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Contraseña')" />
                        <x-text-input id="password" name="password" type="password"
                                      class="block mt-1 w-full border border-border dark:border-border-dark" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-error"/>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="rol" :value="__('Rol')" />
                        <select id="rol" name="rol"
                                class="block mt-1 w-full border border-border dark:border-border-dark">
                            @foreach(['admin'=>'Admin','contador'=>'Contador'] as $val => $label)
                                <option value="{{ $val }}" {{ old('rol') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('rol')" class="mt-2 text-error"/>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="estado" :value="__('Estado')" />
                        <select id="estado" name="estado"
                                class="block mt-1 w-full border border-border dark:border-border-dark">
                            @foreach(['ACTIVO','INACTIVO'] as $val)
                                <option value="{{ $val }}" {{ old('estado') === $val ? 'selected' : '' }}>
                                    {{ ucfirst(strtolower($val)) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('estado')" class="mt-2 text-error"/>
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>
                            Guardar
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>