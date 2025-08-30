<div class="mb-4">
  <x-input-label for="nombre" :value="__('Nombre')" />
  <x-text-input id="nombre" name="nombre" type="text"
                value="{{ old('nombre', $representante->nombre ?? '') }}"
                class="block mt-1 w-full border border-border dark:border-border-dark" />
  <x-input-error :messages="$errors->get('nombre')" class="mt-2 text-error"/>
</div>

<div class="mb-4 grid grid-cols-2 gap-4">
  <div>
    <x-input-label for="dui" :value="__('DUI')" />
    <x-text-input id="dui" name="dui" type="text"
                  value="{{ old('dui', $representante->dui ?? '') }}"
                  class="block mt-1 w-full border border-border dark:border-border-dark" />
    <x-input-error :messages="$errors->get('dui')" class="mt-2 text-error"/>
  </div>
  <div>
    <x-input-label for="telefono" :value="__('Teléfono')" />
    <x-text-input id="telefono" name="telefono" type="text"
                  value="{{ old('telefono', $representante->telefono ?? '') }}"
                  class="block mt-1 w-full border border-border dark:border-border-dark" />
    <x-input-error :messages="$errors->get('telefono')" class="mt-2 text-error"/>
  </div>
</div>

<div class="mb-4">
  <x-input-label for="correo_electronico" :value="__('Correo Electrónico')" />
  <x-text-input id="correo_electronico" name="correo_electronico" type="email"
                value="{{ old('correo_electronico', $representante->correo_electronico ?? '') }}"
                class="block mt-1 w-full border border-border dark:border-border-dark" />
  <x-input-error :messages="$errors->get('correo_electronico')" class="mt-2 text-error"/>
</div>

<div class="mb-4 grid grid-cols-2 gap-4">
  <div>
    <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
    <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date"
                  value="{{ old('fecha_nacimiento', optional($representante->fecha_nacimiento ?? null)->format('Y-m-d')) }}"
                  class="block mt-1 w-full border border-border dark:border-border-dark" />
    <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2 text-error"/>
  </div>
  <div>
    <x-input-label for="fecha_nombramiento" :value="__('Fecha de Nombramiento')" />
    <x-text-input id="fecha_nombramiento" name="fecha_nombramiento" type="date"
                  value="{{ old('fecha_nombramiento', optional($representante->fecha_nombramiento ?? null)->format('Y-m-d')) }}"
                  class="block mt-1 w-full border border-border dark:border-border-dark" />
    <x-input-error :messages="$errors->get('fecha_nombramiento')" class="mt-2 text-error"/>
  </div>
</div>

<div class="mb-4 grid grid-cols-2 gap-4">
  <div>
    <x-input-label for="duracion_meses" :value="__('Duración (meses)')" />
    <x-text-input id="duracion_meses" name="duracion_meses" type="number"
                  value="{{ old('duracion_meses', $representante->duracion_meses ?? '') }}"
                  class="block mt-1 w-full border border-border dark:border-border-dark" />
    <x-input-error :messages="$errors->get('duracion_meses')" class="mt-2 text-error"/>
  </div>
  <div>
    <x-input-label for="fecha_fin_nombramiento" :value="__('Fecha Fin de Nombramiento')" />
    <x-text-input id="fecha_fin_nombramiento" name="fecha_fin_nombramiento" type="date"
                  value="{{ old('fecha_fin_nombramiento', optional($representante->fecha_fin_nombramiento ?? null)->format('Y-m-d')) }}"
                  class="block mt-1 w-full border border-border dark:border-border-dark" />
    <x-input-error :messages="$errors->get('fecha_fin_nombramiento')" class="mt-2 text-error"/>
  </div>
</div>

<div class="mb-4 grid grid-cols-2 gap-4">
  <div>
    <x-input-label for="numero_acta" :value="__('Número de Acta')" />
    <x-text-input id="numero_acta" name="numero_acta" type="text"
                  value="{{ old('numero_acta', $representante->numero_acta ?? '') }}"
                  class="block mt-1 w-full border border-border dark:border-border-dark" />
    <x-input-error :messages="$errors->get('numero_acta')" class="mt-2 text-error"/>
  </div>
  <div>
    <x-input-label for="numero_acuerdo" :value="__('Número de Acuerdo')" />
    <x-text-input id="numero_acuerdo" name="numero_acuerdo" type="text"
                  value="{{ old('numero_acuerdo', $representante->numero_acuerdo ?? '') }}"
                  class="block mt-1 w-full border border-border dark:border-border-dark" />
    <x-input-error :messages="$errors->get('numero_acuerdo')" class="mt-2 text-error"/>
  </div>
</div>