<?php

namespace App\Http\Controllers;

use App\Models\BitacoraAccion;
use App\Models\User;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function index(Request $request)
    {
        $query = BitacoraAccion::with('usuario')->orderBy('fecha_hora', 'desc');

        if ($request->filled('id_usuario')) {
            $query->where('id_usuario', $request->id_usuario);
        }

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        if ($request->filled('tabla_afectada')) {
            $query->where('tabla_afectada', $request->tabla_afectada);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_hora', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_hora', '<=', $request->fecha_hasta);
        }

        $bitacoras = $query->paginate(20)->withQueryString();

        $usuarios = User::all();
        // Obtener tablas únicas
        $tablasUnicas = BitacoraAccion::select('tabla_afectada')->distinct()->pluck('tabla_afectada');

        return view('pages.bitacora.index', compact('bitacoras', 'usuarios', 'tablasUnicas'))
            ->with('title', 'Bitácora de Acciones');
    }

    public function show(BitacoraAccion $bitacora)
    {
        $bitacora->load('usuario');
        return view('pages.bitacora.show', compact('bitacora'))
            ->with('title', 'Detalle de Bitácora');
    }
}
