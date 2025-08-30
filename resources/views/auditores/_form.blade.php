<div class="mb-4">
  <x-input-label for="nombre" :value="__('Nombre')" />
  <x-text-input id="nombre" name="nombre" type="text"
                value="{{ old('nombre', $auditor->nombre ?? '') }}"
                class="block mt-1 w-full border border-border dark:border-border-dark" />
  <x-input-error :messages="$errors->get('nombre')" class="mt-2 text-error"/>
</div>

<div class="mb-4 grid grid-cols-2 gap-4">
  <div>
    <x-input-label for="telefono" :value="__('Teléfono')" />
    <x-text-input id="telefono" name="telefono" type="text"
                  value="{{ old('telefono', $auditor->telefono ?? '') }}"
                  class="block mt-1 w-full border border-border dark:border-border-dark" />
    <x-input-error :messages="$errors->get('telefono')" class="mt-2 text-error"/>
  </div>
  <div>
    <x-input-label for="correo_electronico" :value="__('Correo Electrónico')" />
    <x-text-input id="correo_electronico" name="correo_electronico" type="email"
                  value="{{ old('correo_electronico', $auditor->correo_electronico ?? '') }}"
                  class="block mt-1 w-full border border-border dark:border-border-dark" />
    <x-input-error :messages="$errors->get('correo_electronico')" class="mt-2 text-error"/>
  </div>
</div>

<div class="mb-4">
  <x-input-label for="empresa" :value="__('Empresa')" />
  <x-text-input id="empresa" name="empresa" type="text"
                value="{{ old('empresa', $auditor->empresa ?? '') }}"
                class="block mt-1 w-full border border-border dark:border-border-dark" />
  <x-input-error :messages="$errors->get('empresa')" class="mt-2 text-error"/>
</div>

<div class="mb-4 grid grid-cols-2 gap-4">
  <div>
    <x-input-label for="num_vpcpa" :value="__('Número VPCPA')" />
    <x-text-input id="num_vpcpa" name="num_vpcpa" type="text"
                  value="{{ old('num_vpcpa', $auditor->num_vpcpa ?? '') }}"
                  class="block mt-1 w-full border border-border dark:border-border-dark" />
    <x-input-error :messages="$errors->get('num_vpcpa')" class="mt-2 text-error"/>
  </div>
  <div class="flex items-center mt-6">
    <input type="checkbox" id="nombrado" name="nombrado"
           value="1" {{ old('nombrado', $auditor->nombrado ?? false) ? 'checked' : '' }}
           class="rounded border-border dark:border-border-dark text-primary focus:ring-0" />
    <label for="nombrado" class="ml-2 text-text dark:text-text-dark">
      {{ __('Nombrado') }}
    </label>
  </div>
</div>