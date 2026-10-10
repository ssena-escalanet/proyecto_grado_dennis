@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <x-common.component-card title="Crear Usuario" desc="Ingresa los datos del nuevo usuario">
            <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-12 gap-4 md:gap-6">
                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="nombres">
                            Nombres
                        </label>
                        <input type="text" name="nombres" id="nombres" value="{{ old('nombres') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('nombres')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="apellidos">
                            Apellidos
                        </label>
                        <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('apellidos')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="username">
                            Username
                        </label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('username')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="email">
                            Correo Electrónico
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('email')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="id_rol">
                            Rol
                        </label>
                        <select name="id_rol" id="id_rol" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                            <option value="">Seleccione un rol</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id_rol }}" {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>
                                    {{ $rol->nombre_rol }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_rol')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="estado">
                            Estado
                        </label>
                        <select name="estado" id="estado" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                            <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="password">
                            Contraseña
                        </label>
                        <input type="password" name="password" id="password" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('password')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="password_confirmation">
                            Confirmar Contraseña
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('usuarios.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Guardar Usuario
                    </button>
                </div>
            </form>
        </x-common.component-card>
    </div>
</div>
@endsection
