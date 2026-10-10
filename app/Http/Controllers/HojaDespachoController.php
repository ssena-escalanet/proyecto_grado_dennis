<?php

namespace App\Http\Controllers;

use App\Models\HojaDespacho;
use App\Models\Distribuidor;
use App\Models\Vehiculo;
use App\Http\Requests\StoreHojaDespachoRequest;
use App\Http\Requests\UpdateHojaDespachoRequest;
use Illuminate\Http\Request;

class HojaDespachoController extends Controller
{
    public function index(Request $request)
    {
        $query = HojaDespacho::with(['distribuidor', 'vehiculo'])->orderBy('fecha_despacho', 'desc');

        if ($request->filled('estado_despacho')) {
            $query->where('estado_despacho', $request->estado_despacho);
        }

        $despachos = $query->paginate(10)->withQueryString();
        
        $estados = ['Programado', 'En Ruta', 'Completado', 'Cancelado'];

        return view('pages.hoja-despacho.index', compact('despachos', 'estados'))
            ->with('title', 'Gestión de Hojas de Despacho');
    }

    public function create()
    {
        $distribuidores = Distribuidor::whereIn('estado', ['Activo', 'En Ruta'])->get();
        $vehiculos = Vehiculo::whereIn('estado', ['Disponible', 'En Ruta'])->get();
        
        return view('pages.hoja-despacho.create', compact('distribuidores', 'vehiculos'))
            ->with('title', 'Crear Hoja de Despacho');
    }

    public function store(StoreHojaDespachoRequest $request)
    {
        $data = $request->validated();
        
        $data['carga_total_kg'] = 0;

        HojaDespacho::create($data);

        return redirect()->route('hoja-despacho.index')
            ->with('success', 'Hoja de Despacho creada correctamente.');
    }

    public function show(HojaDespacho $despacho)
    {
        $despacho->load(['distribuidor', 'vehiculo']);
        return view('pages.hoja-despacho.show', compact('despacho'))
            ->with('title', 'Detalle de Hoja de Despacho');
    }

    public function edit(HojaDespacho $despacho)
    {
        if ($despacho->estado_despacho !== 'Programado') {
            return redirect()->route('hoja-despacho.index')
                ->with('error', 'Este despacho ya está en estado ' . $despacho->estado_despacho . ', no se puede editar.');
        }

        $distribuidores = Distribuidor::whereIn('estado', ['Activo', 'En Ruta'])->get();
        $vehiculos = Vehiculo::whereIn('estado', ['Disponible', 'En Ruta'])->get();

        return view('pages.hoja-despacho.edit', compact('despacho', 'distribuidores', 'vehiculos'))
            ->with('title', 'Editar Hoja de Despacho');
    }

    public function update(UpdateHojaDespachoRequest $request, HojaDespacho $despacho)
    {
        if ($despacho->estado_despacho !== 'Programado') {
            return redirect()->route('hoja-despacho.index')
                ->with('error', 'Este despacho ya está en estado ' . $despacho->estado_despacho . ', no se puede editar.');
        }

        $data = $request->validated();
        $despacho->update($data);

        return redirect()->route('hoja-despacho.index')
            ->with('success', 'Hoja de Despacho actualizada correctamente.');
    }

    public function destroy(HojaDespacho $despacho)
    {
        if (!in_array($despacho->estado_despacho, ['Programado', 'Cancelado'])) {
            return redirect()->route('hoja-despacho.index')
                ->with('error', 'Solo se pueden eliminar despachos en estado Programado o Cancelado.');
        }
        
        $despacho->delete();

        return redirect()->route('hoja-despacho.index')
            ->with('success', 'Hoja de Despacho eliminada correctamente.');
    }
}
