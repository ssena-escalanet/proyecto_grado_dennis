@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <x-common.component-card title="Detalle de Producto" desc="Información completa del producto">
            <div class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">ID de Producto</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90 font-medium">{{ $producto->id_producto }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Nombre de Producto</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90 font-medium">{{ $producto->nombre_producto }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Categoría</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $producto->categoria->nombre_categoria ?? 'Sin Categoría' }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Estado</p>
                        <div class="mt-1">
                            @if($producto->estado === 'Activo')
                                <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-theme-xs font-medium text-green-700 dark:bg-green-500/15 dark:text-green-500">Activo</span>
                            @elseif($producto->estado === 'Inactivo')
                                <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-theme-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">Inactivo</span>
                            @elseif($producto->estado === 'Sin Stock')
                                <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-theme-xs font-medium text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-500">Sin Stock</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Stock Disponible</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $producto->stock_disponible }} unidades</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-2">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Precio Unitario</p>
                        <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">Bs. {{ number_format($producto->precio_unitario, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Peso en KG</p>
                        <p class="mt-1 text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ number_format($producto->peso_kg, 3) }} kg</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <a href="{{ route('productos.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Volver
                    </a>
                    <a href="{{ route('productos.edit', $producto) }}" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Editar Producto
                    </a>
                </div>
            </div>
        </x-common.component-card>
    </div>
</div>
@endsection
