@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <x-common.component-card title="Crear Cliente" desc="Ingresa los datos del nuevo cliente">
            <form action="{{ route('clientes.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-12 gap-4 md:gap-6">
                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="nombre_negocio">
                            Nombre del Negocio
                        </label>
                        <input type="text" name="nombre_negocio" id="nombre_negocio" value="{{ old('nombre_negocio') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" placeholder="Ej. Distribuidora El Sol" required>
                        @error('nombre_negocio')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="representante">
                            Representante
                        </label>
                        <input type="text" name="representante" id="representante" value="{{ old('representante') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" placeholder="Ej. Juan Pérez" required>
                        @error('representante')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="nit_ci">
                            NIT / CI
                        </label>
                        <input type="text" name="nit_ci" id="nit_ci" value="{{ old('nit_ci') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" placeholder="Ej. 1234567015" required>
                        @error('nit_ci')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="telefono">
                            Teléfono
                        </label>
                        <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" placeholder="Ej. 71234567">
                        @error('telefono')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="direccion">
                            Dirección
                        </label>
                        <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" placeholder="Ej. Calle Sagárnaga #123, La Paz" required>
                        @error('direccion')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="coordenada_lat">
                            Coordenada Latitud
                        </label>
                        <input type="number" step="0.0000001" name="coordenada_lat" id="coordenada_lat" value="{{ old('coordenada_lat') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" placeholder="Ej. -16.5000000">
                        <p class="mt-1 text-theme-xs text-gray-500">Formato decimal. Ej: -17.783327</p>
                        @error('coordenada_lat')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="coordenada_lon">
                            Coordenada Longitud
                        </label>
                        <input type="number" step="0.0000001" name="coordenada_lon" id="coordenada_lon" value="{{ old('coordenada_lon') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" placeholder="Ej. -68.1500000">
                        <p class="mt-1 text-theme-xs text-gray-500">Formato decimal. Ej: -63.182140</p>
                        @error('coordenada_lon')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="estado">
                            Estado
                        </label>
                        <select name="estado" id="estado" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500">
                            <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('clientes.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Guardar Cliente
                    </button>
                </div>
            </form>
        </x-common.component-card>
    </div>
</div>
@endsection
