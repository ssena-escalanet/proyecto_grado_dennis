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
            <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">Clientes</h2>
            <a href="{{ route('clientes.create') }}" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 transition-colors">
                Nuevo Cliente
            </a>
        </div>

        <x-common.component-card title="Gestión de Clientes" desc="Administra los clientes del sistema">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <table class="w-full min-w-[1000px]">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">ID</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nombre Negocio</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Representante</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">NIT/CI</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Teléfono</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Dirección</p>
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
                            @forelse($clientes as $cliente)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $cliente->id_cliente }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-800 font-medium text-theme-sm dark:text-white/90">{{ $cliente->nombre_negocio }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $cliente->representante }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $cliente->nit_ci }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $cliente->telefono ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ Str::limit($cliente->direccion, 20) }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        @if($cliente->estado === 'Activo')
                                            <span class="inline-flex rounded-full bg-success-500/10 px-3 py-1 text-theme-xs font-medium text-success-500">Activo</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-red-500/10 px-3 py-1 text-theme-xs font-medium text-red-500">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 sm:px-6 text-end">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('clientes.show', $cliente) }}" class="text-brand-500 hover:text-brand-600">Ver</a>
                                            <a href="{{ route('clientes.edit', $cliente) }}" class="text-brand-500 hover:text-brand-600">Editar</a>
                                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-600">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-8 text-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">No hay clientes registrados.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $clientes->links() }}
            </div>
        </x-common.component-card>
    </div>
</div>
@endsection
