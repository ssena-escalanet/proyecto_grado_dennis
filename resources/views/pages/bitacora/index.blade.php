@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12">
        
        <div class="mb-6">
            <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">Bitácora de Acciones</h2>
            <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">Registro automático de actividades del sistema.</p>
        </div>

        <x-common.component-card title="Filtros de Búsqueda" desc="">
            <form action="{{ route('bitacora.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                
                <div>
                    <label class="mb-2 block text-theme-xs font-medium text-gray-700 dark:text-gray-400">Usuario</label>
                    <select name="id_usuario" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500">
                        <option value="">Todos los Usuarios</option>
                        @foreach($usuarios as $user)
                            <option value="{{ $user->id_usuario }}" {{ request('id_usuario') == $user->id_usuario ? 'selected' : '' }}>
                                {{ $user->username }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-theme-xs font-medium text-gray-700 dark:text-gray-400">Acción</label>
                    <select name="accion" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500">
                        <option value="">Todas las Acciones</option>
                        <option value="Crear" {{ request('accion') == 'Crear' ? 'selected' : '' }}>Crear</option>
                        <option value="Editar" {{ request('accion') == 'Editar' ? 'selected' : '' }}>Editar</option>
                        <option value="Eliminar" {{ request('accion') == 'Eliminar' ? 'selected' : '' }}>Eliminar</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-theme-xs font-medium text-gray-700 dark:text-gray-400">Tabla Afectada</label>
                    <select name="tabla_afectada" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500">
                        <option value="">Todas las Tablas</option>
                        @foreach($tablasUnicas as $tabla)
                            <option value="{{ $tabla }}" {{ request('tabla_afectada') == $tabla ? 'selected' : '' }}>
                                {{ $tabla }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-theme-xs font-medium text-gray-700 dark:text-gray-400">Rango de Fechas</label>
                    <div class="flex gap-2">
                        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="w-1/2 rounded-lg border border-gray-200 bg-white px-2 py-2 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500" placeholder="Desde">
                        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="w-1/2 rounded-lg border border-gray-200 bg-white px-2 py-2 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-500" placeholder="Hasta">
                    </div>
                </div>

                <div class="md:col-span-4 flex justify-end gap-2 mt-2">
                    <a href="{{ route('bitacora.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white px-6 py-2.5 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Limpiar filtros
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-6 py-2.5 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Buscar
                    </button>
                </div>
            </form>
        </x-common.component-card>

        <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="w-full min-w-[900px]">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 text-start"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">ID / Fecha</p></th>
                            <th class="px-5 py-3 text-start"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Usuario</p></th>
                            <th class="px-5 py-3 text-start"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Acción</p></th>
                            <th class="px-5 py-3 text-start"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Tabla Afectada</p></th>
                            <th class="px-5 py-3 text-start"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">IP Acceso</p></th>
                            <th class="px-5 py-3 text-end"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Acciones</p></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bitacoras as $bitacora)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-5 py-4">
                                    <p class="text-gray-800 font-medium text-theme-sm dark:text-white/90">#{{ $bitacora->id_bitacora }}</p>
                                    <p class="text-gray-500 text-theme-xs mt-0.5 dark:text-gray-400">{{ $bitacora->fecha_hora->format('d/m/Y H:i:s') }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-gray-800 text-theme-sm font-medium dark:text-white/90">
                                        {{ $bitacora->usuario ? $bitacora->usuario->username : 'Sistema / Anónimo' }}
                                    </p>
                                </td>
                                <td class="px-5 py-4">
                                    @if($bitacora->accion === 'Crear')
                                        <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-theme-xs font-medium text-green-700 dark:bg-green-500/15 dark:text-green-500">Crear</span>
                                    @elseif($bitacora->accion === 'Editar')
                                        <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-theme-xs font-medium text-blue-700 dark:bg-blue-500/15 dark:text-blue-500">Editar</span>
                                    @elseif($bitacora->accion === 'Eliminar')
                                        <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-theme-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">Eliminar</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-gray-50 px-3 py-1 text-theme-xs font-medium text-gray-700 dark:bg-gray-500/15 dark:text-gray-300">{{ $bitacora->accion }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-gray-800 text-theme-sm dark:text-white/90">{{ $bitacora->tabla_afectada }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $bitacora->ip_acceso }}</p>
                                </td>
                                <td class="px-5 py-4 text-end">
                                    <a href="{{ route('bitacora.show', $bitacora) }}" class="text-brand-500 hover:text-brand-600 font-medium">Ver Detalle</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center"><p class="text-gray-500 text-theme-sm dark:text-gray-400">No hay registros en la bitácora.</p></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4">
            {{ $bitacoras->links() }}
        </div>
    </div>
</div>
@endsection
