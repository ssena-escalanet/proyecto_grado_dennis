@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-8 xl:col-start-3">
        <x-common.component-card title="Detalle de Categoría" desc="Información completa de la categoría seleccionada">
            <div class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 dark:border-gray-800 pb-6">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">ID de Categoría</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90 font-medium">{{ $categoria->id_categoria }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Nombre</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90 font-medium">{{ $categoria->nombre_categoria }}</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 dark:border-gray-800 pb-6">
                    <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Descripción</p>
                    <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $categoria->descripcion ?? 'Sin descripción' }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-2">
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Fecha de Creación</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $categoria->created_at ? $categoria->created_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Última Actualización</p>
                        <p class="mt-1 text-theme-sm text-gray-800 dark:text-white/90">{{ $categoria->updated_at ? $categoria->updated_at->format('d/m/Y H:i A') : 'N/A' }}</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <a href="{{ route('categorias.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Volver
                    </a>
                    <a href="{{ route('categorias.edit', $categoria) }}" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Editar Categoría
                    </a>
                </div>
            </div>
        </x-common.component-card>
    </div>
</div>
@endsection
