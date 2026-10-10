@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-success-500/10 p-4 text-success-500 border border-success-500/20">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 rounded-lg bg-red-500/10 p-4 text-red-500 border border-red-500/20">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">Categorías de Producto</h2>
            <a href="{{ route('categorias.create') }}" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 transition-colors">
                Nueva Categoría
            </a>
        </div>

        <x-common.component-card title="Gestión de Categorías" desc="Administra las categorías de productos">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <table class="w-full min-w-[700px]">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">ID</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nombre</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Descripción</p>
                                </th>
                                <th class="px-5 py-3 text-end sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Acciones</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categorias as $categoria)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $categoria->id_categoria }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-800 font-medium text-theme-sm dark:text-white/90">{{ $categoria->nombre_categoria }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $categoria->descripcion ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6 text-end">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('categorias.show', $categoria) }}" class="text-brand-500 hover:text-brand-600">Ver</a>
                                            <a href="{{ route('categorias.edit', $categoria) }}" class="text-brand-500 hover:text-brand-600">Editar</a>
                                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-600">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">No hay categorías registradas.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $categorias->links() }}
            </div>
        </x-common.component-card>
    </div>
</div>
@endsection
