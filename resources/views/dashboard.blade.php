<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between
                bg-surface dark:bg-surface-dark
                border-b border-border dark:border-border-dark
                px-4 py-3 sm:px-6">
      <h2 class="font-semibold text-xl text-text dark:text-text-dark">
        {{ __('Dashboard') }}
      </h2>
      @if(Auth::user()->rol === 'admin')
        <a href="{{ route('users.index') }}"
           class="px-4 py-2 bg-primary text-primary-contrast rounded hover:bg-primary/90">
          {{ __('Administrar Usuarios') }}
        </a>
      @endif
    </div>
  </x-slot>

  <div class="py-12 bg-background dark:bg-background-dark">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      {{-- Panel Principal --}}
      <div class="bg-surface dark:bg-surface-dark overflow-hidden shadow-sm sm:rounded-lg border border-border dark:border-border-dark">
        <div class="p-6 text-text dark:text-text-dark">
          {{ __("You're logged in!") }}
        </div>
      </div>

      {{-- Sólo admin ve el panel de usuarios --}}
      @if(Auth::user()->rol === 'admin')
        <div class="bg-surface dark:bg-surface-dark overflow-hidden shadow-sm sm:rounded-lg border border-border dark:border-border-dark">
          <div class="p-6">
            <h3 class="text-lg font-medium text-text dark:text-text-dark mb-2">
              {{ __('Gestión de Usuarios') }}
            </h3>
            <p class="text-sm text-muted dark:text-muted-dark mb-4">
              {{ __('Crear, editar y eliminar cuentas de usuario.') }}
            </p>
            <a href="{{ route('users.create') }}"
               class="px-3 py-2 bg-secondary text-secondary-contrast rounded hover:bg-secondary/90">
              {{ __('Nuevo Usuario') }}
            </a>
          </div>
        </div>
      @endif
    </div>
  </div>
</x-app-layout>