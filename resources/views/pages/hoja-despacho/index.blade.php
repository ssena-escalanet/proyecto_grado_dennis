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

        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">Hojas de Despacho</h2>
            
            <a href="{{ route('hoja-despacho.create') }}" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 transition-colors">
                Nuevo Despacho
            </a>
        </div>

        <x-common.component-card title="Gestión de Despachos" desc="Administra las hojas de ruta y despachos">
            <!-- Filtros -->
            <div class="mb-6 rounded-lg border border-gray-100 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-900">
                <form action="{{ route('hoja-despacho.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="w-full sm:w-1/3">
                        <label class="mb-2 block text-theme-xs font-medium text-gray-700 dark:text-gray-400">Estado del Despacho</label>
                        <select name="estado_despacho" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500">
                            <option value="">Todos los Estados</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado }}" {{ request('estado_despacho') == $estado ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-1/3 flex items-end gap-2">
                        <button type="submit" class="inline-flex h-[42px] items-center justify-center rounded-lg bg-gray-800 px-6 text-theme-sm font-medium text-white hover:bg-gray-900 dark:bg-white/10 dark:hover:bg-white/20 transition-colors">
                            Filtrar
                        </button>
                        <a href="{{ route('hoja-despacho.index') }}" class="inline-flex h-[42px] items-center justify-center rounded-lg border border-gray-200 bg-white px-6 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tabla -->
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <table class="w-full min-w-[1000px]">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="px-5 py-3 text-start"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">ID / Fecha</p></th>
                                <th class="px-5 py-3 text-start"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Distribuidor</p></th>
                                <th class="px-5 py-3 text-start"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Vehículo</p></th>
                                <th class="px-5 py-3 text-start"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Horarios (Sal/Lleg)</p></th>
                                <th class="px-5 py-3 text-start"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Km (Ini/Fin)</p></th>
                                <th class="px-5 py-3 text-start"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Estado</p></th>
                                <th class="px-5 py-3 text-end"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Acciones</p></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($despachos as $despacho)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-5 py-4">
                                        <p class="text-gray-800 font-medium text-theme-sm dark:text-white/90">#{{ $despacho->id_despacho }}</p>
                                        <p class="text-gray-500 text-theme-xs mt-0.5 dark:text-gray-400">{{ $despacho->fecha_despacho->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="px-5 py-4"><p class="text-gray-800 text-theme-sm dark:text-white/90">{{ $despacho->distribuidor->nombres }} {{ $despacho->distribuidor->apellidos }}</p></td>
                                    <td class="px-5 py-4">
                                        <p class="text-gray-800 text-theme-sm dark:text-white/90">{{ $despacho->vehiculo->placa ?? 'N/A' }}</p>
                                        <p class="text-gray-500 text-theme-xs mt-0.5 dark:text-gray-400">{{ $despacho->vehiculo->marca ?? '' }}</p>
                                    </td>
                                    <td class="px-5 py-4">
                                        <p class="text-gray-800 text-theme-sm dark:text-white/90">{{ \Carbon\Carbon::parse($despacho->hora_salida)->format('H:i') }}</p>
                                        <p class="text-gray-500 text-theme-xs mt-0.5 dark:text-gray-400">{{ $despacho->hora_llegada ? \Carbon\Carbon::parse($despacho->hora_llegada)->format('H:i') : '--:--' }}</p>
                                    </td>
                                    <td class="px-5 py-4">
                                        <p class="text-gray-800 text-theme-sm dark:text-white/90">{{ $despacho->kilometraje_inicial }} km</p>
                                        <p class="text-gray-500 text-theme-xs mt-0.5 dark:text-gray-400">{{ $despacho->kilometraje_final ? $despacho->kilometraje_final . ' km' : '---' }}</p>
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($despacho->estado_despacho === 'Programado')
                                            <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-theme-xs font-medium text-blue-700 dark:bg-blue-500/15 dark:text-blue-500">Programado</span>
                                        @elseif($despacho->estado_despacho === 'En Ruta')
                                            <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-theme-xs font-medium text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-500">En Ruta</span>
                                        @elseif($despacho->estado_despacho === 'Completado')
                                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-theme-xs font-medium text-green-700 dark:bg-green-500/15 dark:text-green-500">Completado</span>
                                        @elseif($despacho->estado_despacho === 'Cancelado')
                                            <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-theme-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">Cancelado</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-end">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('hoja-despacho.show', $despacho) }}" class="text-brand-500 hover:text-brand-600">Ver</a>
                                            
                                            @if($despacho->estado_despacho === 'Programado')
                                                <a href="{{ route('hoja-despacho.edit', $despacho) }}" class="text-brand-500 hover:text-brand-600">Editar</a>
                                            @endif
                                            
                                            @if(in_array($despacho->estado_despacho, ['Programado', 'Cancelado']))
                                                <form action="{{ route('hoja-despacho.destroy', $despacho) }}" method="POST" onsubmit="return confirm('¿Eliminar hoja de despacho permanentemente?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-600">Eliminar</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-8 text-center"><p class="text-gray-500 text-theme-sm dark:text-gray-400">No hay hojas de despacho registradas.</p></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $despachos->links() }}
            </div>
        </x-common.component-card>
    </div>
</div>
@endsection
