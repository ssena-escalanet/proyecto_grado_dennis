<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVehiculoRequest;
use App\Http\Requests\UpdateVehiculoRequest;

class VehiculoController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehiculo::query();

        if ($request->filled('estado') && $request->estado !== 'Todos') {
            $query->where('estado', $request->estado);
        }

        $vehiculos = $query->paginate(10)->withQueryString();
        
        $estadoFiltro = $request->estado ?? 'Todos';

        return view('pages.vehiculos.index', compact('vehiculos', 'estadoFiltro'));
    }

    public function create()
    {
        return view('pages.vehiculos.create');
    }

    public function store(StoreVehiculoRequest $request)
    {
        Vehiculo::create($request->validated());
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo creado exitosamente.');
    }

    public function show(Vehiculo $vehiculo)
    {
        return view('pages.vehiculos.show', compact('vehiculo'));
    }

    public function edit(Vehiculo $vehiculo)
    {
        return view('pages.vehiculos.edit', compact('vehiculo'));
    }

    public function update(UpdateVehiculoRequest $request, Vehiculo $vehiculo)
    {
        $vehiculo->update($request->validated());
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo actualizado exitosamente.');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        // Add check for relationship when HojaDespacho is created
        $vehiculo->delete();
        return redirect()->route('vehiculos.index')->with('success', 'Vehículo eliminado exitosamente.');
    }
}
