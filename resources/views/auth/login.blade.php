<x-guest-layout>
    <form
        method="POST"
        action="{{ route('login') }}"
        class="max-w-md mx-auto p-6 bg-surface dark:bg-surface-dark rounded-lg shadow"
    >
        @csrf

        <!-- Usuario -->
        <div>
            <x-input-label for="username" :value="__('Usuario')" />
            <x-text-input
                id="username"
                name="username"
                type="text"
                :value="old('username')"
                required
                autofocus
                class="block mt-1 w-full
                       border border-border dark:border-border-dark
                       focus:ring-2 focus:ring-primary/50 focus:border-primary
                       dark:bg-surface-dark dark:text-text-dark"
            />
            <x-input-error
                :messages="$errors->get('username')"
                class="mt-2 text-error"
            />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input
                id="password"
                name="password"
                type="password"
                required
                class="block mt-1 w-full
                       border border-border dark:border-border-dark
                       focus:ring-2 focus:ring-primary/50 focus:border-primary
                       dark:bg-surface-dark dark:text-text-dark"
            />
            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2 text-error"
            />
        </div>

        <!-- Recordarme -->
        <div class="flex items-center mt-4">
            <input
                id="remember_me"
                name="remember"
                type="checkbox"
                class="rounded border-border dark:border-border-dark
                       text-primary focus:ring-primary"
            />
            <label
                for="remember_me"
                class="ml-2 text-sm text-text dark:text-text-dark"
            >
                {{ __('Recordarme') }}
            </label>
        </div>

        <!-- Botón Ingresar -->
        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="ml-3">
                {{ __('Ingresar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>