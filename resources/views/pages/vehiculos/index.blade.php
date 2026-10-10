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
            <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">Vehículos</h2>
            
            <div class="flex flex-col sm:flex-row gap-4 items-center w-full sm:w-auto">
                <form action="{{ route('vehiculos.index') }}" method="GET" class="w-full sm:w-auto">
                    <select name="estado" onchange="this.form.submit()" class="w-full sm:w-auto rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500">
                        <option value="Todos" {{ $estadoFiltro == 'Todos' ? 'selected' : '' }}>Todos los estados</option>
                        <option value="Disponible" {{ $estadoFiltro == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="En Ruta" {{ $estadoFiltro == 'En Ruta' ? 'selected' : '' }}>En Ruta</option>
                        <option value="Mantenimiento" {{ $estadoFiltro == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                    </select>
                </form>

                <a href="{{ route('vehiculos.create') }}" class="inline-flex w-full sm:w-auto items-center justify-center rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 transition-colors">
                    Nuevo Vehículo
                </a>
            </div>
        </div>

        <x-common.component-card title="Gestión de Vehículos" desc="Administra los vehículos de la flota">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <table class="w-full min-w-[800px]">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">ID</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Placa</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Marca</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Modelo</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Capacidad (kg)</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Estado</p>
                                </th>
                                <th class="px-5 py-3 text-end sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Acciones</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehiculos as $vehiculo)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $vehiculo->id_vehiculo }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-800 font-medium text-theme-sm dark:text-white/90">{{ $vehiculo->placa }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $vehiculo->marca }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $vehiculo->modelo }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ number_format($vehiculo->capacidad_carga_kg, 2) }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        @if($vehiculo->estado === 'Disponible')
                                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-theme-xs font-medium text-green-700 dark:bg-green-500/15 dark:text-green-500">Disponible</span>
                                        @elseif($vehiculo->estado === 'En Ruta')
                                            <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-theme-xs font-medium text-blue-700 dark:bg-blue-500/15 dark:text-blue-500">En Ruta</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-yellow-50 px-3 py-1 text-theme-xs font-medium text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-500">Mantenimiento</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 sm:px-6 text-end">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('vehiculos.show', $vehiculo) }}" class="text-brand-500 hover:text-brand-600">Ver</a>
                                            <a href="{{ route('vehiculos.edit', $vehiculo) }}" class="text-brand-500 hover:text-brand-600">Editar</a>
                                            <form action="{{ route('vehiculos.destroy', $vehiculo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este vehículo?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-600">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-8 text-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">No hay vehículos registrados.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $vehiculos->links() }}
            </div>
        </x-common.component-card>
    </div>
</div>
@endsection
