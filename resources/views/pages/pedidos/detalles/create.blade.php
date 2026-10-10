@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <x-common.component-card title="Agregar Productos Dinámicamente" desc="Pedido #{{ $pedido->id_pedido }} - Módulo de Venta">
            
            @if(session('error'))
                <div class="mb-4 rounded-lg bg-red-500/10 p-4 text-red-600 border border-red-500/20">
                    {{ session('error') }}
                </div>
            @endif

            <div x-data="carritoPedido()" x-cloak class="space-y-6">
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
                    <div class="max-w-full overflow-x-auto custom-scrollbar">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                <tr>
                                    <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 dark:text-gray-400">Producto Disponible</th>
                                    <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 dark:text-gray-400 w-32">Precio (Bs)</th>
                                    <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 dark:text-gray-400 w-32">Cantidad</th>
                                    <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 dark:text-gray-400 w-32">Subtotal (Bs)</th>
                                    <th class="px-5 py-3 text-center text-theme-xs font-medium text-gray-500 dark:text-gray-400 w-24">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                <template x-for="(fila, index) in filas" :key="index">
                                    <tr>
                                        <td class="px-5 py-3">
                                            <select x-model="fila.id_producto" @change="actualizarFila(index, $event)" class="w-full rounded border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                                <option value="">Seleccione un producto...</option>
                                                @foreach($productos as $prod)
                                                    <option value="{{ $prod->id_producto }}" 
                                                            data-precio="{{ $prod->precio_unitario }}"
                                                            data-stock="{{ $prod->stock_disponible }}">
                                                        {{ $prod->nombre_producto }} (Stock: {{ $prod->stock_disponible }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-5 py-3 text-theme-sm font-medium text-gray-600 dark:text-gray-300" x-text="fila.precio.toFixed(2)"></td>
                                        <td class="px-5 py-3">
                                            <input type="number" x-model.number="fila.cantidad" @input="calcularSubtotal(index)" min="1" :max="fila.stock_max" class="w-full rounded border border-gray-200 px-3 py-1 text-theme-sm text-center dark:border-gray-700 dark:bg-gray-800 dark:text-white" :disabled="!fila.id_producto">
                                        </td>
                                        <td class="px-5 py-3 text-theme-sm font-bold text-gray-800 dark:text-white/90" x-text="fila.subtotal.toFixed(2)"></td>
                                        <td class="px-5 py-3 text-center">
                                            <button type="button" @click="eliminarFila(index)" class="text-red-500 hover:text-red-700" title="Quitar Fila">
                                                <svg class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-200 dark:border-gray-800">
                    <button type="button" @click="agregarFila()" class="px-5 py-2.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-theme-sm font-medium transition-colors dark:bg-blue-500/20 dark:text-blue-400 dark:hover:bg-blue-500/30">
                        + Nueva Fila
                    </button>
                    <div class="text-lg font-bold text-gray-800 dark:text-white/90">
                        Total Proyectado: Bs <span x-text="totalGeneral"></span>
                    </div>
                </div>

                <form action="{{ route('pedidos.detalles.store', $pedido) }}" method="POST" id="formCarrito">
                    @csrf
                    <input type="hidden" name="detalles" :value="JSON.stringify(filas.filter(f => f.id_producto && f.cantidad > 0))">
                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('pedidos.detalles.index', $pedido) }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex rounded-lg bg-brand-500 px-6 py-2.5 text-theme-sm font-medium text-white hover:bg-brand-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors" :disabled="filas.filter(f => f.id_producto && f.cantidad > 0).length === 0">
                            Guardar Productos
                        </button>
                    </div>
                </form>
            </div>

            <script>
            function carritoPedido() {
                return {
                    filas: [{ id_producto: '', precio: 0, cantidad: 1, subtotal: 0, stock_max: 0 }],
                    
                    agregarFila() {
                        this.filas.push({ id_producto: '', precio: 0, cantidad: 1, subtotal: 0, stock_max: 0 });
                    },
                    
                    eliminarFila(index) {
                        this.filas.splice(index, 1);
                        if (this.filas.length === 0) this.agregarFila();
                    },
                    
                    actualizarFila(index, event) {
                        const select = event.target;
                        const option = select.options[select.selectedIndex];
                        
                        if (option.value) {
                            this.filas[index].precio = parseFloat(option.dataset.precio);
                            this.filas[index].stock_max = parseInt(option.dataset.stock);
                            this.calcularSubtotal(index);
                        } else {
                            this.filas[index].precio = 0;
                            this.filas[index].stock_max = 0;
                            this.filas[index].subtotal = 0;
                        }
                    },
                    
                    calcularSubtotal(index) {
                        let fila = this.filas[index];
                        if(fila.cantidad > fila.stock_max) fila.cantidad = fila.stock_max;
                        if(fila.cantidad < 1) fila.cantidad = 1;
                        
                        fila.subtotal = parseFloat((fila.precio * fila.cantidad).toFixed(2));
                    },
                    
                    get totalGeneral() {
                        return this.filas.reduce((acc, fila) => acc + fila.subtotal, 0).toFixed(2);
                    }
                }
            }
            </script>
        </x-common.component-card>
    </div>
</div>
@endsection
