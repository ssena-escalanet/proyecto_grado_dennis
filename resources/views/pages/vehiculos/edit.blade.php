@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <x-common.component-card title="Editar Vehículo: {{ $vehiculo->placa }}" desc="Modifica los datos del vehículo">
            <form action="{{ route('vehiculos.update', $vehiculo) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-12 gap-4 md:gap-6">
                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="placa">
                            Placa
                        </label>
                        <input type="text" name="placa" id="placa" value="{{ old('placa', $vehiculo->placa) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('placa')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="marca">
                            Marca
                        </label>
                        <input type="text" name="marca" id="marca" value="{{ old('marca', $vehiculo->marca) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('marca')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="modelo">
                            Modelo
                        </label>
                        <input type="text" name="modelo" id="modelo" value="{{ old('modelo', $vehiculo->modelo) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('modelo')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="capacidad_carga_kg">
                            Capacidad (kg)
                        </label>
                        <input type="number" step="0.01" name="capacidad_carga_kg" id="capacidad_carga_kg" value="{{ old('capacidad_carga_kg', $vehiculo->capacidad_carga_kg) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('capacidad_carga_kg')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="estado">
                            Estado
                        </label>
                        <select name="estado" id="estado" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                            <option value="Disponible" {{ old('estado', $vehiculo->estado) == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="En Ruta" {{ old('estado', $vehiculo->estado) == 'En Ruta' ? 'selected' : '' }}>En Ruta</option>
                            <option value="Mantenimiento" {{ old('estado', $vehiculo->estado) == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('vehiculos.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Actualizar Vehículo
                    </button>
                </div>
            </form>
        </x-common.component-card>
    </div>
</div>
@endsection
