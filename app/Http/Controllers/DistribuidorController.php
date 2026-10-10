<?php

namespace App\Http\Controllers;

use App\Models\Distribuidor;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDistribuidorRequest;
use App\Http\Requests\UpdateDistribuidorRequest;

class DistribuidorController extends Controller
{
    public function index(Request $request)
    {
        $query = Distribuidor::query();

        if ($request->filled('estado') && $request->estado !== 'Todos') {
            $query->where('estado', $request->estado);
        }

        $distribuidores = $query->paginate(10)->withQueryString();
        
        $estadoFiltro = $request->estado ?? 'Todos';

        return view('pages.distribuidores.index', compact('distribuidores', 'estadoFiltro'));
    }

    public function create()
    {
        return view('pages.distribuidores.create');
    }

    public function store(StoreDistribuidorRequest $request)
    {
        Distribuidor::create($request->validated());
        return redirect()->route('distribuidores.index')->with('success', 'Distribuidor creado exitosamente.');
    }

    public function show(Distribuidor $distribuidor)
    {
        return view('pages.distribuidores.show', compact('distribuidor'));
    }

    public function edit(Distribuidor $distribuidor)
    {
        return view('pages.distribuidores.edit', compact('distribuidor'));
    }

    public function update(UpdateDistribuidorRequest $request, Distribuidor $distribuidor)
    {
        $distribuidor->update($request->validated());
        return redirect()->route('distribuidores.index')->with('success', 'Distribuidor actualizado exitosamente.');
    }

    public function destroy(Distribuidor $distribuidor)
    {
        // Add check for relationship when HojaDespacho is created
        $distribuidor->delete();
        return redirect()->route('distribuidores.index')->with('success', 'Distribuidor eliminado exitosamente.');
    }
}
