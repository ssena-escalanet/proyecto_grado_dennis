@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between">
        <h2 class="text-title-md2 font-semibold">Seleccionar Pedidos (Despacho #{{ $despacho->id_despacho }})</h2>
        <a href="{{ route('despachos.detalles.index', $despacho) }}" class="px-5 py-2 border rounded">Cancelar</a>
    </div>

    @if(session('error')) <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">{{ session('error') }}</div> @endif

    <form action="{{ route('despachos.detalles.store', $despacho) }}" method="POST">
        @csrf
        <x-common.component-card title="Lotes de Pedido Disponibles">
            <div class="p-4 bg-gray-50 mb-4 rounded border font-medium">
                Capacidad Máxima de tu Vehículo: <span class="text-brand-500">{{ $despacho->vehiculo->capacidad_carga_kg }} kg</span>
            </div>
            
            <table class="w-full text-left">
                <thead class="border-b bg-gray-50">
                    <tr>
                        <th class="p-3 w-10"></th>
                        <th class="p-3">Pedido Padre</th>
                        <th class="p-3">Cliente</th>
                        <th class="p-3">Producto (Cant)</th>
                        <th class="p-3">Peso a Cargar</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($detallesDisponibles as $det)
                        <tr>
                            <td class="p-3">
                                <input type="checkbox" name="detalles[]" value="{{ $det->id_detalle_pedido }}" class="w-4 h-4 cursor-pointer">
                            </td>
                            <td class="p-3">#{{ $det->pedido->id_pedido }}</td>
                            <td class="p-3">{{ $det->pedido->cliente->nombre_negocio }}</td>
                            <td class="p-3">{{ $det->producto->nombre_producto }} ({{ $det->cantidad }} uni)</td>
                            <td class="p-3 text-blue-600 font-medium">{{ number_format($det->cantidad * $det->producto->peso_kg, 2) }} kg</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-6 text-center text-gray-500">No hay lotes disponibles para cargar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-common.component-card>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-brand-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-brand-600">Cargar Seleccionados al Vehículo</button>
        </div>
    </form>
</div>
@endsection
