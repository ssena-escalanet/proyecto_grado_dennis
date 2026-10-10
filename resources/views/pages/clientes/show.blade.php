@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <x-common.component-card title="Detalle de Cliente" desc="Información completa del cliente seleccionado">
            <div class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">ID de Cliente</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90 font-medium">{{ $cliente->id_cliente }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Nombre del Negocio</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90 font-medium">{{ $cliente->nombre_negocio }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Estado</p>
                        <div class="mt-1">
                            @if($cliente->estado === 'Activo')
                                <span class="inline-flex rounded-full bg-success-500/10 px-3 py-1 text-theme-xs font-medium text-success-500">Activo</span>
                            @else
                                <span class="inline-flex rounded-full bg-red-500/10 px-3 py-1 text-theme-xs font-medium text-red-500">Inactivo</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Representante</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $cliente->representante }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">NIT/CI</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $cliente->nit_ci }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Teléfono</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $cliente->telefono ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 dark:border-gray-800 pb-6">
                    <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Dirección</p>
                    <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $cliente->direccion }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Ubicación GPS</p>
                        @if($cliente->coordenada_lat && $cliente->coordenada_lon)
                            <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90 mb-2">
                                Lat: {{ $cliente->coordenada_lat }} | Lon: {{ $cliente->coordenada_lon }}
                            </p>
                            <a href="https://www.google.com/maps?q={{ $cliente->coordenada_lat }},{{ $cliente->coordenada_lon }}" target="_blank" class="inline-flex items-center gap-2 text-theme-sm font-medium text-brand-500 hover:text-brand-600 transition-colors">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                Ver en Google Maps
                            </a>
                        @else
                            <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">Sin coordenadas registradas</p>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-2">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Fecha de Creación</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $cliente->created_at ? $cliente->created_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Última Actualización</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $cliente->updated_at ? $cliente->updated_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <a href="{{ route('clientes.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Volver
                    </a>
                    <a href="{{ route('clientes.edit', $cliente) }}" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Editar Cliente
                    </a>
                </div>
            </div>
        </x-common.component-card>
    </div>
</div>
@endsection
