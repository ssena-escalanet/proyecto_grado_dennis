@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <x-common.component-card title="Editar Producto" desc="Modifica los datos del producto existente">
            <form action="{{ route('productos.update', $producto) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-12 gap-4 md:gap-6">
                    <div class="col-span-12 md:col-span-12">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="nombre_producto">
                            Nombre del Producto
                        </label>
                        <input type="text" name="nombre_producto" id="nombre_producto" value="{{ old('nombre_producto', $producto->nombre_producto) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('nombre_producto')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="id_categoria">
                            Categoría
                        </label>
                        <select name="id_categoria" id="id_categoria" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}" {{ old('id_categoria', $producto->id_categoria) == $categoria->id_categoria ? 'selected' : '' }}>
                                    {{ $categoria->nombre_categoria }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_categoria')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="estado">
                            Estado
                        </label>
                        <select name="estado" id="estado" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                            <option value="Activo" {{ old('estado', $producto->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ old('estado', $producto->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="Sin Stock" {{ old('estado', $producto->estado) == 'Sin Stock' ? 'selected' : '' }}>Sin Stock</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-4">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="precio_unitario">
                            Precio Unitario (Bs)
                        </label>
                        <input type="number" step="0.01" min="0.01" name="precio_unitario" id="precio_unitario" value="{{ old('precio_unitario', $producto->precio_unitario) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('precio_unitario')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-4">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="peso_kg">
                            Peso (Kg)
                        </label>
                        <input type="number" step="0.001" min="0.001" name="peso_kg" id="peso_kg" value="{{ old('peso_kg', $producto->peso_kg) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('peso_kg')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-4">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="stock_disponible">
                            Stock Disponible
                        </label>
                        <input type="number" min="0" step="1" name="stock_disponible" id="stock_disponible" value="{{ old('stock_disponible', $producto->stock_disponible) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('stock_disponible')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('productos.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Actualizar Producto
                    </button>
                </div>
            </form>
        </x-common.component-card>
    </div>
</div>
@endsection
