@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-8 xl:col-start-3">
        <x-common.component-card title="Editar Rol: {{ $rol->nombre_rol }}" desc="Modifica los datos del rol">
            <form action="{{ route('roles.update', $rol) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="nombre_rol">
                        Nombre del Rol
                    </label>
                    <input type="text" name="nombre_rol" id="nombre_rol" value="{{ old('nombre_rol', $rol->nombre_rol) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                    @error('nombre_rol')
                        <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="descripcion">
                        Descripción
                    </label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500">{{ old('descripcion', $rol->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('roles.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Actualizar Rol
                    </button>
                </div>
            </form>
        </x-common.component-card>
    </div>
</div>
@endsection
