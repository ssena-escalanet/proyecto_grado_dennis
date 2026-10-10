@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <x-common.component-card title="Detalle de Usuario" desc="Información completa del usuario seleccionado">
            <div class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">ID de Usuario</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90 font-medium">{{ $usuario->id_usuario }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Nombre Completo</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90 font-medium">{{ $usuario->nombres }} {{ $usuario->apellidos }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Estado</p>
                        <div class="mt-1">
                            @if($usuario->estado === 'Activo')
                                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-theme-xs font-medium text-green-700 dark:bg-green-500/15 dark:text-green-500">Activo</span>
                            @else
                                <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-theme-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">Inactivo</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Username</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $usuario->username }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Correo Electrónico</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $usuario->email }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Rol</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $usuario->rol->nombre_rol ?? 'Sin Rol' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-2">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Fecha de Creación</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Última Actualización</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $usuario->updated_at ? $usuario->updated_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <a href="{{ route('usuarios.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Volver
                    </a>
                    <a href="{{ route('usuarios.edit', $usuario) }}" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Editar Usuario
                    </a>
                </div>
            </div>
        </x-common.component-card>
    </div>
</div>
@endsection
