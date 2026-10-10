@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">Carrito del Pedido #{{ $pedido->id_pedido }}</h2>
                <p class="text-theme-sm text-gray-500 mt-1 dark:text-gray-400">Estado: <span class="font-medium text-gray-800 dark:text-white">{{ $pedido->estado_pedido }}</span></p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('pedidos.show', $pedido) }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800">
                    Volver a Cabecera
                </a>
                
                @if($pedido->estado_pedido === 'Pendiente')
                    <a href="{{ route('pedidos.detalles.create', $pedido) }}" class="inline-flex rounded-lg bg-brand-500 px-5 py-2.5 text-theme-sm font-medium text-white hover:bg-brand-600">
                        + Agregar Productos
                    </a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-500/10 p-4 text-green-600 border border-green-500/20">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 rounded-lg bg-red-500/10 p-4 text-red-600 border border-red-500/20">
                {{ session('error') }}
            </div>
        @endif

        <x-common.component-card title="Productos en el Pedido" desc="">
            @if($pedido->detalles->count() > 0)
                <div class="overflow-x-auto rounded-lg border border-gray-100 dark:border-gray-800">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 dark:text-gray-400">Producto</th>
                                <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 dark:text-gray-400">Cantidad</th>
                                <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 dark:text-gray-400">Precio Venta</th>
                                <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 dark:text-gray-400">Subtotal</th>
                                @if($pedido->estado_pedido === 'Pendiente')
                                    <th class="px-5 py-3 text-end text-theme-xs font-medium text-gray-500 dark:text-gray-400">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($pedido->detalles as $detalle)
                                <tr>
                                    <td class="px-5 py-4 text-theme-sm text-gray-800 dark:text-white/90">
                                        {{ $detalle->producto->nombre_producto }}
                                    </td>
                                    <td class="px-5 py-4 text-theme-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $detalle->cantidad }}
                                    </td>
                                    <td class="px-5 py-4 text-theme-sm text-gray-800 dark:text-white/90">
                                        Bs {{ number_format($detalle->precio_venta, 2) }}
                                    </td>
                                    <td class="px-5 py-4 text-theme-sm font-bold text-gray-800 dark:text-white/90">
                                        Bs {{ number_format($detalle->subtotal, 2) }}
                                    </td>
                                    @if($pedido->estado_pedido === 'Pendiente')
                                        <td class="px-5 py-4 text-end">
                                            <form action="{{ route('pedidos.detalles.destroy', [$pedido, $detalle]) }}" method="POST" onsubmit="return confirm('¿Eliminar producto del pedido y devolver stock?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-theme-sm">Eliminar</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <td colspan="3" class="px-5 py-4 text-end font-bold text-gray-800 dark:text-white/90">TOTAL GENERAL:</td>
                                <td class="px-5 py-4 font-bold text-brand-600 dark:text-brand-500 text-lg">
                                    Bs {{ number_format($pedido->total_pagar, 2) }}
                                </td>
                                @if($pedido->estado_pedido === 'Pendiente')
                                    <td></td>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($pedido->estado_pedido === 'Pendiente' && $pedido->detalles->count() > 0)
                    <div class="mt-6 flex justify-end">
                        <form action="{{ route('pedidos.confirmar', $pedido) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex rounded-lg bg-green-500 px-6 py-3 text-theme-sm font-medium text-white hover:bg-green-600 transition-colors" onclick="return confirm('¿Confirmar pedido? Ya no podrás modificar los productos y pasará a En Despacho.')">
                                Confirmar Pedido
                            </button>
                        </form>
                    </div>
                @endif
            @else
                <div class="py-10 text-center">
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Este pedido aún no tiene productos.</p>
                </div>
            @endif
        </x-common.component-card>
    </div>
</div>
@endsection
