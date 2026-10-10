@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 xl:col-span-10 xl:col-start-2">
        <x-common.component-card title="Crear Hoja de Despacho" desc="Registrar un nuevo despacho (Cabecera)">
            <form action="{{ route('hoja-despacho.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-12 gap-4 md:gap-6">
                    
                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="id_distribuidor">
                            Distribuidor
                        </label>
                        <select name="id_distribuidor" id="id_distribuidor" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                            <option value="">Seleccione un distribuidor</option>
                            @foreach($distribuidores as $distribuidor)
                                <option value="{{ $distribuidor->id_distribuidor }}" {{ old('id_distribuidor') == $distribuidor->id_distribuidor ? 'selected' : '' }}>
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
                                <option value="{{ $vehiculo->id_vehiculo }}" {{ old('id_vehiculo') == $vehiculo->id_vehiculo ? 'selected' : '' }}>
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
                        <input type="date" name="fecha_despacho" id="fecha_despacho" value="{{ old('fecha_despacho', \Carbon\Carbon::now()->format('Y-m-d')) }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('fecha_despacho')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="estado_despacho">
                            Estado del Despacho
                        </label>
                        <select name="estado_despacho" id="estado_despacho" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                            <option value="Programado" {{ old('estado_despacho') == 'Programado' ? 'selected' : '' }}>Programado</option>
                            <option value="En Ruta" {{ old('estado_despacho') == 'En Ruta' ? 'selected' : '' }}>En Ruta</option>
                            <option value="Completado" {{ old('estado_despacho') == 'Completado' ? 'selected' : '' }}>Completado</option>
                            <option value="Cancelado" {{ old('estado_despacho') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('estado_despacho')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="hora_salida">
                            Hora de Salida
                        </label>
                        <input type="time" name="hora_salida" id="hora_salida" value="{{ old('hora_salida') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('hora_salida')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="hora_llegada">
                            Hora de Llegada (Opcional)
                        </label>
                        <input type="time" name="hora_llegada" id="hora_llegada" value="{{ old('hora_llegada') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500">
                        @error('hora_llegada')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="kilometraje_inicial">
                            Kilometraje Inicial
                        </label>
                        <input type="number" min="0" step="1" name="kilometraje_inicial" id="kilometraje_inicial" value="{{ old('kilometraje_inicial') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500" required>
                        @error('kilometraje_inicial')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <label class="mb-2 block text-theme-sm font-medium text-gray-800 dark:text-white/90" for="kilometraje_final">
                            Kilometraje Final (Opcional)
                        </label>
                        <input type="number" min="0" step="1" name="kilometraje_final" id="kilometraje_final" value="{{ old('kilometraje_final') }}" class="w-full rounded-lg border border-gray-200 bg-transparent px-5 py-3 text-theme-sm text-gray-800 outline-none transition focus:border-brand-500 dark:border-gray-800 dark:text-white/90 dark:focus:border-brand-500">
                        @error('kilometraje_final')
                            <p class="mt-1 text-theme-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('hoja-despacho.index') }}" class="inline-flex rounded-lg border border-gray-200 bg-white px-5 py-3 text-theme-sm font-medium text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex rounded-lg bg-brand-500 px-5 py-3 text-theme-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        Guardar Despacho
                    </button>
                </div>
            </form>
        </x-common.component-card>
    </div>
</div>
@endsection
