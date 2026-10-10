@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        
        @if($pedido->estado_pedido !== 'Pendiente')
            <div class="mb-4 rounded-lg bg-yellow-500/10 p-4 text-yellow-700 border border-yellow-500/20 dark:text-yellow-500">
                Este pedido ya está en estado <strong>{{ $pedido->estado_pedido }}</strong>. Solo se pueden editar pedidos en estado Pendiente.
            </div>
        @endif
        
        <x-common.component-card title="Editar Pedido #{{ $pedido->id_pedido }}" desc="Modificar la cabecera del pedido">
            
            @if($pedido->estado_pedido === 'Pendiente')
            <form action="{{ route('pedidos.update', $pedido) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
            @else
            <div class="space-y-6 opacity-75 pointer-events-none">
            @endif
                
                <div class="grid grid-cols-12 gap-4 md:gap-6">
                    
                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="id_cliente">
                            Cliente
                        </label>
                        <select name="id_cliente" id="id_cliente" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id_cliente }}" {{ old('id_cliente', $pedido->id_cliente) == $cliente->id_cliente ? 'selected' : '' }}>
                                    {{ $cliente->nombre_negocio }} ({{ $cliente->representante }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_cliente')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="estado_pedido">
                            Estado del Pedido
                        </label>
                        <select name="estado_pedido" id="estado_pedido" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                            <option value="Pendiente" {{ old('estado_pedido', $pedido->estado_pedido) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="En Despacho" {{ old('estado_pedido', $pedido->estado_pedido) == 'En Despacho' ? 'selected' : '' }}>En Despacho</option>
                            <option value="Entregado" {{ old('estado_pedido', $pedido->estado_pedido) == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                            <option value="Rechazado" {{ old('estado_pedido', $pedido->estado_pedido) == 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
                            <option value="Pagado" {{ old('estado_pedido', $pedido->estado_pedido) == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="Cancelado" {{ old('estado_pedido', $pedido->estado_pedido) == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('estado_pedido')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="fecha_pedido">
                            Fecha de Pedido
                        </label>
                        <input type="datetime-local" name="fecha_pedido" id="fecha_pedido" value="{{ old('fecha_pedido', $pedido->fecha_pedido->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('fecha_pedido')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="fecha_entrega_est">
                            Fecha de Entrega Estimada
                        </label>
                        <input type="date" name="fecha_entrega_est" id="fecha_entrega_est" value="{{ old('fecha_entrega_est', $pedido->fecha_entrega_est->format('Y-m-d')) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('fecha_entrega_est')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

            @if($pedido->estado_pedido === 'Pendiente')
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('pedidos.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Actualizar Pedido
                    </button>
                </div>
            </form>
            @else
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('pedidos.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Volver
                    </a>
                </div>
            @endif
        </x-common.component-card>
    </div>
</div>
@endsection
