<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-text dark:text-text-dark">
      {{ __('Nuevo Representante') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-background dark:bg-background-dark">
    <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
      <div class="bg-surface dark:bg-surface-dark p-6 rounded-lg shadow">
        <form action="{{ route('representantes.store') }}" method="POST">
          @csrf

          @include('representantes._form')

          <div class="flex justify-end mt-6">
            <x-primary-button>
              {{ __('Guardar Representante') }}
            </x-primary-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>