@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-8 xl:col-start-3">
        <x-common.component-card title="Registro de Bitácora #{{ $bitacora->id_bitacora }}" desc="Detalles de la acción registrada">
            <div class="space-y-6">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Usuario</p>
                        @if($bitacora->usuario)
                            <a href="{{ route('usuarios.show', $bitacora->usuario) }}" class="mt-1 inline-block text-theme-sm text-brand-500 hover:text-brand-600 font-medium transition-colors">
                                {{ $bitacora->usuario->username }} (ID: {{ $bitacora->usuario->id_usuario }})
                            </a>
                        @else
                            <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">Sistema / Anónimo</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Acción Realizada</p>
                        <div class="mt-1">
                            @if($bitacora->accion === 'Crear')
                                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-theme-xs font-medium text-green-700 dark:bg-green-500/15 dark:text-green-500">Crear</span>
                            @elseif($bitacora->accion === 'Editar')
                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-theme-xs font-medium text-blue-700 dark:bg-blue-500/15 dark:text-blue-500">Editar</span>
                            @elseif($bitacora->accion === 'Eliminar')
                                <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-theme-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">Eliminar</span>
                            @else
                                <span class="inline-flex rounded-full bg-gray-50 px-3 py-1 text-theme-xs font-medium text-gray-700 dark:bg-gray-500/15 dark:text-gray-300">{{ $bitacora->accion }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Tabla Afectada</p>
                        <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $bitacora->tabla_afectada }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Dirección IP</p>
                        <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90 font-mono">{{ $bitacora->ip_acceso }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Fecha y Hora Exacta</p>
                        <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $bitacora->fecha_hora->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>

                <div class="mt-4 rounded-lg border border-blue-200 bg-blue-50 p-4 dark:border-blue-500/20 dark:bg-blue-500/10">
                    <div class="flex items-start gap-3">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-500/20">
                            <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-theme-sm font-medium text-blue-800 dark:text-blue-400">Registro inmutable (RN-50)</h3>
                            <p class="mt-1 text-theme-xs text-blue-600 dark:text-blue-300">
                                Los registros de bitácora son de solo lectura para garantizar la trazabilidad de auditoría. 
                                No pueden ser modificados ni eliminados del sistema.
                            </p>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('bitacora.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                    Volver a la Lista
                </a>
            </div>
        </x-common.component-card>
    </div>
</div>
@endsection
