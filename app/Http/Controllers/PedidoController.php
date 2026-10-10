<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::with('cliente')->orderBy('fecha_pedido', 'desc');

        if ($request->filled('estado_pedido')) {
            $query->where('estado_pedido', $request->estado_pedido);
        }

        $pedidos = $query->paginate(10)->withQueryString();
        
        $estados = ['Pendiente', 'En Despacho', 'Entregado', 'Rechazado', 'Pagado', 'Cancelado'];

        return view('pages.pedidos.index', compact('pedidos', 'estados'))
            ->with('title', 'Gestión de Pedidos');
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('pages.pedidos.create', compact('clientes'))
            ->with('title', 'Crear Pedido');
    }

    public function store(StorePedidoRequest $request)
    {
        $data = $request->validated();
        
        $data['total_pagar'] = 0;
        $data['saldo_pendiente'] = 0;

        Pedido::create($data);

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido creado correctamente.');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load('cliente');
        return view('pages.pedidos.show', compact('pedido'))
            ->with('title', 'Detalle del Pedido');
    }

    public function edit(Pedido $pedido)
    {
        if ($pedido->estado_pedido !== 'Pendiente') {
            return redirect()->route('pedidos.index')
                ->with('error', 'Este pedido ya está en estado ' . $pedido->estado_pedido . ', no se puede editar.');
        }

        $clientes = Cliente::all();
        return view('pages.pedidos.edit', compact('pedido', 'clientes'))
            ->with('title', 'Editar Pedido');
    }

    public function update(UpdatePedidoRequest $request, Pedido $pedido)
    {
        if ($pedido->estado_pedido !== 'Pendiente') {
            return redirect()->route('pedidos.index')
                ->with('error', 'Este pedido ya está en estado ' . $pedido->estado_pedido . ', no se puede editar.');
        }

        $data = $request->validated();
        $pedido->update($data);

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(Pedido $pedido)
    {
        if (!in_array($pedido->estado_pedido, ['Pendiente', 'Cancelado'])) {
            return redirect()->route('pedidos.index')
                ->with('error', 'Solo se pueden eliminar pedidos en estado Pendiente o Cancelado.');
        }
        
        $pedido->delete();

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido eliminado correctamente.');
    }
}
