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
            <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">Usuarios</h2>
            
            <a href="{{ route('usuarios.create') }}" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 transition-colors">
                Nuevo Usuario
            </a>
        </div>

        <x-common.component-card title="Gestión de Usuarios" desc="Administra los accesos y roles del sistema">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <table class="w-full min-w-[900px]">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">ID</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nombre Completo</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Username</p>
                                </th>
                                <th class="px-5 py-3 text-start sm:px-6">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Rol</p>
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
                            @forelse($usuarios as $usuario)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $usuario->id_usuario }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-800 font-medium text-theme-sm dark:text-white/90">{{ $usuario->nombres }} {{ $usuario->apellidos }}</p>
                                        <p class="text-gray-500 text-theme-xs mt-1 dark:text-gray-400">{{ $usuario->email }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-800 text-theme-sm dark:text-white/90">{{ $usuario->username }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-theme-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                            {{ $usuario->rol->nombre_rol ?? 'Sin Rol' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        @if($usuario->estado === 'Activo')
                                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-theme-xs font-medium text-green-700 dark:bg-green-500/15 dark:text-green-500">Activo</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-theme-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 sm:px-6 text-end">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('usuarios.show', $usuario) }}" class="text-brand-500 hover:text-brand-600">Ver</a>
                                            <a href="{{ route('usuarios.edit', $usuario) }}" class="text-brand-500 hover:text-brand-600">Editar</a>
                                            <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-600">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-8 text-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">No hay usuarios registrados.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $usuarios->links() }}
            </div>
        </x-common.component-card>
    </div>
</div>
@endsection
