@extends('layouts.app')
@section('content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <div class="mb-6 flex justify-between">
            <div>
                <h2 class="text-title-md2 font-semibold">Hoja de Ruta #{{ $despacho->id_despacho }}</h2>
                <p>Carga Total: <span class="font-bold">{{ $despacho->carga_total_kg }} kg</span> / Capacidad: {{ $despacho->vehiculo->capacidad_carga_kg }} kg</p>
                <p>Estado del Despacho: <b>{{ $despacho->estado_despacho }}</b></p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('hoja-despacho.show', $despacho) }}" class="px-5 py-2 border rounded-lg">Volver</a>
                @if($despacho->estado_despacho === 'Programado')
                    <a href="{{ route('despachos.detalles.create', $despacho) }}" class="px-5 py-2 bg-brand-500 text-white rounded-lg">+ Cargar Pedidos</a>
                @endif
                @if($despacho->estado_despacho !== 'Completado' && $despacho->detalles()->where('estado_entrega', 'Pendiente')->count() === 0 && $despacho->detalles()->count() > 0)
                    <form action="{{ route('despachos.completar', $despacho) }}" method="POST" class="inline">
                        @csrf
                        <button class="px-5 py-2 bg-green-500 text-white rounded-lg" onclick="return confirm('¿Completar y liberar vehículo?')">Finalizar Despacho</button>
                    </form>
                @endif
            </div>
        </div>

        @if(session('success')) <div class="mb-4 bg-green-100 text-green-700 p-4 rounded">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">{{ session('error') }}</div> @endif

        <x-common.component-card title="Paradas / Entregas">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-3"># Parada</th>
                        <th class="p-3">Cliente</th>
                        <th class="p-3">Producto / Cant.</th>
                        <th class="p-3">Estado</th>
                        <th class="p-3">Monto Cobrado</th>
                        <th class="p-3 text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($despacho->detalles->sortBy('orden_visita') as $parada)
                        <tr>
                            <td class="p-3 font-bold">{{ $parada->orden_visita }}</td>
                            <td class="p-3">{{ $parada->detallePedido->pedido->cliente->nombre_negocio }}</td>
                            <td class="p-3">{{ $parada->detallePedido->producto->nombre_producto }} ({{ $parada->detallePedido->cantidad }} uni)</td>
                            <td class="p-3">
                                @if($parada->estado_entrega == 'Entregado') <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Entregado</span>
                                @elseif($parada->estado_entrega == 'Rechazado') <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Rechazado</span>
                                @else <span class="bg-gray-100 px-2 py-1 rounded text-xs">Pendiente</span> @endif
                            </td>
                            <td class="p-3">Bs {{ number_format($parada->monto_cobrado, 2) }}</td>
                            <td class="p-3 text-end flex justify-end gap-2">
                                @if($parada->estado_entrega === 'Pendiente' && $despacho->estado_despacho !== 'Completado')
                                    <a href="{{ route('despachos.detalles.edit', [$despacho, $parada]) }}" class="text-blue-500 hover:underline">Liquidar</a>
                                    <form action="{{ route('despachos.detalles.destroy', [$despacho, $parada]) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 hover:underline">Remover</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">Liquidado</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center p-6 text-gray-500">No hay paradas asignadas aún.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-common.component-card>
    </div>
</div>
@endsection
