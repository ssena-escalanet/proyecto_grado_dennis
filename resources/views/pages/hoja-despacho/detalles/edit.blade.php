@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto" x-data="{ estado: 'Entregado' }">
    <div class="mb-6">
        <h2 class="text-title-md2 font-semibold">Liquidar Parada #{{ $detalle->orden_visita }}</h2>
        <p class="text-gray-500 mt-1">Pedido #{{ $detalle->detallePedido->id_pedido }} - Cliente: {{ $detalle->detallePedido->pedido->cliente->nombre_negocio }}</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded mb-6 border border-red-200">
            <ul>@foreach($errors->all() as $err) <li>- {{ $err }}</li> @endforeach</ul>
        </div>
    @endif

    <x-common.component-card title="Registro de Entrega">
        <form action="{{ route('despachos.detalles.update', [$despacho, $detalle]) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block mb-2 font-medium">Estado Final de Entrega</label>
                <select name="estado_entrega" x-model="estado" class="w-full rounded border px-3 py-2">
                    <option value="Entregado">Entregado (Cobro Total)</option>
                    <option value="Rechazado">Rechazado</option>
                </select>
            </div>

            <div x-show="estado === 'Entregado'" x-cloak>
                <label class="block mb-2 font-medium">Hora de Entrega</label>
                <input type="time" name="hora_entrega" value="{{ now()->format('H:i') }}" class="w-full rounded border px-3 py-2">
                <p class="mt-2 text-sm text-gray-500">El sistema cobrará automáticamente el saldo pendiente (Bs {{ number_format($detalle->detallePedido->pedido->saldo_pendiente, 2) }}).</p>
            </div>

            <div x-show="estado === 'Rechazado'" x-cloak>
                <label class="block mb-2 font-medium text-red-600">Motivo del Rechazo (Obligatorio)</label>
                <input type="text" name="motivo_rechazo" class="w-full rounded border border-red-300 px-3 py-2" placeholder="Ej: Negocio cerrado, cliente no quiso pagar, etc.">
            </div>

            <div>
                <label class="block mb-2 font-medium">Observaciones (Opcional)</label>
                <textarea name="observaciones" rows="2" class="w-full rounded border px-3 py-2"></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('despachos.detalles.index', $despacho) }}" class="px-5 py-2 border rounded">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded">Liquidar Parada</button>
            </div>
        </form>
    </x-common.component-card>
</div>
@endsection
