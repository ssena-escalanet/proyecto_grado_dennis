@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        
        @if($despacho->estado_despacho !== 'Programado')
            <div class="mb-4 rounded-lg bg-yellow-500/10 p-4 text-yellow-700 border border-yellow-500/20 dark:text-yellow-500">
                Este despacho ya está en estado <strong>{{ $despacho->estado_despacho }}</strong>, no se puede editar.
            </div>
        @endif
        
        <x-common.component-card title="Editar Hoja de Despacho #{{ $despacho->id_despacho }}" desc="Modificar la cabecera del despacho">
            
            @if($despacho->estado_despacho === 'Programado')
            <form action="{{ route('hoja-despacho.update', $despacho) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
            @else
            <div class="space-y-6 opacity-75 pointer-events-none">
            @endif
                
                <div class="grid grid-cols-12 gap-4 md:gap-6">
                    
                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="id_distribuidor">
                            Distribuidor
                        </label>
                        <select name="id_distribuidor" id="id_distribuidor" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                            <option value="">Seleccione un distribuidor</option>
                            @foreach($distribuidores as $distribuidor)
                                <option value="{{ $distribuidor->id_distribuidor }}" {{ old('id_distribuidor', $despacho->id_distribuidor) == $distribuidor->id_distribuidor ? 'selected' : '' }}>
                                    {{ $distribuidor->nombres }} {{ $distribuidor->apellidos }} ({{ $distribuidor->ci }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_distribuidor')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="id_vehiculo">
                            Vehículo
                        </label>
                        <select name="id_vehiculo" id="id_vehiculo" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                            <option value="">Seleccione un vehículo</option>
                            @foreach($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id_vehiculo }}" {{ old('id_vehiculo', $despacho->id_vehiculo) == $vehiculo->id_vehiculo ? 'selected' : '' }}>
                                    {{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }} (Cap: {{ $vehiculo->capacidad_carga_kg }} kg)
                                </option>
                            @endforeach
                        </select>
                        @error('id_vehiculo')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="fecha_despacho">
                            Fecha de Despacho
                        </label>
                        <input type="date" name="fecha_despacho" id="fecha_despacho" value="{{ old('fecha_despacho', $despacho->fecha_despacho->format('Y-m-d')) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('fecha_despacho')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="estado_despacho">
                            Estado del Despacho
                        </label>
                        <select name="estado_despacho" id="estado_despacho" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                            <option value="Programado" {{ old('estado_despacho', $despacho->estado_despacho) == 'Programado' ? 'selected' : '' }}>Programado</option>
                            <option value="En Ruta" {{ old('estado_despacho', $despacho->estado_despacho) == 'En Ruta' ? 'selected' : '' }}>En Ruta</option>
                            <option value="Completado" {{ old('estado_despacho', $despacho->estado_despacho) == 'Completado' ? 'selected' : '' }}>Completado</option>
                            <option value="Cancelado" {{ old('estado_despacho', $despacho->estado_despacho) == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('estado_despacho')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="hora_salida">
                            Hora de Salida
                        </label>
                        <input type="time" name="hora_salida" id="hora_salida" value="{{ old('hora_salida', \Carbon\Carbon::parse($despacho->hora_salida)->format('H:i')) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('hora_salida')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="hora_llegada">
                            Hora de Llegada (Opcional)
                        </label>
                        <input type="time" name="hora_llegada" id="hora_llegada" value="{{ old('hora_llegada', $despacho->hora_llegada ? \Carbon\Carbon::parse($despacho->hora_llegada)->format('H:i') : '') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500">
                        @error('hora_llegada')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="kilometraje_inicial">
                            Kilometraje Inicial
                        </label>
                        <input type="number" min="0" step="1" name="kilometraje_inicial" id="kilometraje_inicial" value="{{ old('kilometraje_inicial', $despacho->kilometraje_inicial) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('kilometraje_inicial')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="kilometraje_final">
                            Kilometraje Final (Opcional)
                        </label>
                        <input type="number" min="0" step="1" name="kilometraje_final" id="kilometraje_final" value="{{ old('kilometraje_final', $despacho->kilometraje_final) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500">
                        @error('kilometraje_final')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

            @if($despacho->estado_despacho === 'Programado')
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('hoja-despacho.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Actualizar Despacho
                    </button>
                </div>
            </form>
            @else
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('hoja-despacho.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Volver
                    </a>
                </div>
            @endif
        </x-common.component-card>
    </div>
</div>
@endsection
