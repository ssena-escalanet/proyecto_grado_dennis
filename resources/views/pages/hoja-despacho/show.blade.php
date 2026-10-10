@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <x-common.component-card title="Detalle de Hoja de Despacho #{{ $despacho->id_despacho }}" desc="Información de la cabecera del despacho">
            <div class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Distribuidor</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90 font-medium">{{ $despacho->distribuidor->nombres }} {{ $despacho->distribuidor->apellidos }}</p>
                        <p class="text-theme-xs text-gray-500 mt-1 dark:text-gray-400">CI: {{ $despacho->distribuidor->ci }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Vehículo</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90 font-medium">{{ $despacho->vehiculo->placa ?? 'N/A' }}</p>
                        <p class="text-theme-xs text-gray-500 mt-1 dark:text-gray-400">{{ $despacho->vehiculo->marca ?? '' }} {{ $despacho->vehiculo->modelo ?? '' }} (Cap: {{ $despacho->vehiculo->capacidad_carga_kg ?? '0' }} kg)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Fecha de Despacho</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $despacho->fecha_despacho->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Estado del Despacho</p>
                        <div class="mt-1">
                            @if($despacho->estado_despacho === 'Programado')
                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-theme-xs font-medium text-blue-700 dark:bg-blue-500/15 dark:text-blue-500">Programado</span>
                            @elseif($despacho->estado_despacho === 'En Ruta')
                                <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-theme-xs font-medium text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-500">En Ruta</span>
                            @elseif($despacho->estado_despacho === 'Completado')
                                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-theme-xs font-medium text-green-700 dark:bg-green-500/15 dark:text-green-500">Completado</span>
                            @elseif($despacho->estado_despacho === 'Cancelado')
                                <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-theme-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">Cancelado</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Carga Total (Kg)</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ number_format($despacho->carga_total_kg, 2) }} kg</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Horarios (Salida - Llegada)</p>
                        <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">
                            {{ \Carbon\Carbon::parse($despacho->hora_salida)->format('H:i') }} - 
                            {{ $despacho->hora_llegada ? \Carbon\Carbon::parse($despacho->hora_llegada)->format('H:i') : '--:--' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Kilometraje (Inicial - Final)</p>
                        <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $despacho->kilometraje_inicial }} km - 
                            {{ $despacho->kilometraje_final ? $despacho->kilometraje_final . ' km' : '---' }}
                        </p>
                    </div>
                </div>
            </div>
        </x-common.component-card>

        <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-5 dark:border-blue-500/20 dark:bg-blue-500/10">
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-500/20">
                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-theme-sm font-medium text-blue-800 dark:text-blue-400">Información del Sistema</h3>
                    <p class="mt-1 text-theme-sm text-blue-600 dark:text-blue-300">
                        El detalle del despacho se implementará en la FASE 3 (módulo de detalle_despacho).
                        La carga total en kg se calculará automáticamente en base a los productos asignados.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('hoja-despacho.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                Volver
            </a>
            @if($despacho->estado_despacho === 'Programado')
            <a href="{{ route('hoja-despacho.edit', $despacho) }}" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                Editar Despacho
            </a>
            @endif
            <a href="{{ route('despachos.detalles.index', $despacho) }}" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                Gestionar Ruta de Despacho
            </a>
        </div>

    </div>
</div>
@endsection
