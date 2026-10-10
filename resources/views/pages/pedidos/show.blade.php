@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <x-common.component-card title="Detalle de Pedido #{{ $pedido->id_pedido }}" desc="Información de la cabecera del pedido">
            <div class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Cliente</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90 font-medium">{{ $pedido->cliente->nombre_negocio ?? 'N/A' }}</p>
                        <p class="text-theme-xs text-gray-500 mt-1 dark:text-gray-400">{{ $pedido->cliente->representante ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Estado del Pedido</p>
                        <div class="mt-1">
                            @if($pedido->estado_pedido === 'Pendiente')
                                <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-theme-xs font-medium text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-500">Pendiente</span>
                            @elseif($pedido->estado_pedido === 'En Despacho')
                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-theme-xs font-medium text-blue-700 dark:bg-blue-500/15 dark:text-blue-500">En Despacho</span>
                            @elseif($pedido->estado_pedido === 'Entregado')
                                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-theme-xs font-medium text-green-700 dark:bg-green-500/15 dark:text-green-500">Entregado</span>
                            @elseif($pedido->estado_pedido === 'Rechazado')
                                <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-theme-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">Rechazado</span>
                            @elseif($pedido->estado_pedido === 'Pagado')
                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-theme-xs font-medium text-green-800 dark:bg-green-600/20 dark:text-green-600">Pagado</span>
                            @elseif($pedido->estado_pedido === 'Cancelado')
                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-theme-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">Cancelado</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Fecha del Pedido</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Fecha de Entrega Estimada</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $pedido->fecha_entrega_est->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-2">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Total a Pagar</p>
                        <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">Bs. {{ number_format($pedido->total_pagar, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Saldo Pendiente</p>
                        <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">Bs. {{ number_format($pedido->saldo_pendiente, 2) }}</p>
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
                        El detalle del pedido se implementará en la FASE 3 (módulo de detalle_pedido). 
                        Los cálculos de los totales y saldos se realizarán automáticamente.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('pedidos.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                Volver
            </a>
            @if($pedido->estado_pedido === 'Pendiente')
            <a href="{{ route('pedidos.edit', $pedido) }}" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                Editar Pedido
            </a>
            @endif
            @if(in_array($pedido->estado_pedido, ['Pendiente', 'En Despacho']))
            <a href="{{ route('pedidos.detalles.index', $pedido) }}" class="inline-flex rounded-lg bg-blue-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-blue-600 transition-colors">
                @if($pedido->estado_pedido === 'Pendiente')
                    {{ $pedido->detalles()->count() > 0 ? 'Ver Productos del Pedido' : 'Agregar Productos al Pedido' }}
                @else
                    Ver Productos del Pedido
                @endif
            </a>
            @endif
        </div>

    </div>
</div>
@endsection
