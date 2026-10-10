<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\DetallePedido;
use App\Http\Requests\StorePedidoDetalleRequest;
use Illuminate\Support\Facades\DB;

class PedidoDetalleController extends Controller
{
    public function index(Pedido $pedido)
    {
        $pedido->load(['cliente', 'detalles.producto']);
        return view('pages.pedidos.detalles.index', compact('pedido'))
            ->with('title', 'Gestionar Productos del Pedido #' . $pedido->id_pedido);
    }
    
    public function create(Pedido $pedido)
    {
        if ($pedido->estado_pedido !== 'Pendiente') {
            return redirect()->route('pedidos.show', $pedido)
                ->with('error', 'Solo se pueden agregar productos a pedidos Pendientes.');
        }

        $productos = Producto::where('estado', 'Activo')
            ->where('stock_disponible', '>', 0)
            ->get();
            
        return view('pages.pedidos.detalles.create', compact('pedido', 'productos'))
            ->with('title', 'Agregar Productos al Pedido #' . $pedido->id_pedido);
    }
    
    public function store(StorePedidoDetalleRequest $request, Pedido $pedido)
    {
        if ($pedido->estado_pedido !== 'Pendiente') {
            return redirect()->route('pedidos.detalles.index', $pedido)
                ->with('error', 'El pedido ya no está en estado Pendiente.');
        }

        $detallesCrudos = json_decode($request->detalles, true);

        if (!is_array($detallesCrudos) || count($detallesCrudos) === 0) {
            return back()->with('error', 'Debe agregar al menos un producto.');
        }

        // Agrupar duplicados
        $detallesAgrupados = collect($detallesCrudos)
            ->groupBy('id_producto')
            ->map(fn($items, $idProducto) => [
                'id_producto' => $idProducto,
                'cantidad' => $items->sum('cantidad'),
            ])
            ->values()
            ->all();

        try {
            DB::transaction(function () use ($detallesAgrupados, $pedido) {
                foreach ($detallesAgrupados as $item) {
                    $producto = Producto::lockForUpdate()->findOrFail($item['id_producto']);
                    
                    if ($producto->estado !== 'Activo' && $producto->estado !== 'Sin Stock') {
                        throw new \Exception("El producto {$producto->nombre_producto} no está disponible.");
                    }

                    if ($producto->stock_disponible < $item['cantidad']) {
                        throw new \Exception("Stock insuficiente para el producto: {$producto->nombre_producto}. Quedan {$producto->stock_disponible}.");
                    }
                    
                    if ($item['cantidad'] <= 0) {
                        throw new \Exception("La cantidad debe ser mayor a 0.");
                    }

                    $precio_venta = $producto->precio_unitario;
                    $subtotal = $item['cantidad'] * $precio_venta;

                    DetallePedido::create([
                        'id_pedido' => $pedido->id_pedido,
                        'id_producto' => $producto->id_producto,
                        'cantidad' => $item['cantidad'],
                        'precio_venta' => $precio_venta,
                        'subtotal' => $subtotal,
                    ]);

                    $producto->stock_disponible -= $item['cantidad'];
                    
                    if ($producto->stock_disponible == 0) {
                        $producto->estado = 'Sin Stock';
                    }
                    $producto->save();
                }

                // Recalcular totales en cabecera
                $pedido->total_pagar = $pedido->detalles()->sum('subtotal');
                $pedido->saldo_pendiente = $pedido->total_pagar; // Considerando que cobrado aún no existe (Fase 3.2)
                $pedido->save();
            });

            return redirect()->route('pedidos.detalles.index', $pedido)
                ->with('success', 'Productos agregados correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function destroy(Pedido $pedido, DetallePedido $detalle)
    {
        if ($pedido->estado_pedido !== 'Pendiente') {
            return redirect()->route('pedidos.detalles.index', $pedido)
                ->with('error', 'No se pueden eliminar productos de un pedido confirmado.');
        }

        try {
            DB::transaction(function () use ($pedido, $detalle) {
                $producto = Producto::lockForUpdate()->findOrFail($detalle->id_producto);
                
                $producto->stock_disponible += $detalle->cantidad;
                
                if ($producto->estado === 'Sin Stock' && $producto->stock_disponible > 0) {
                    $producto->estado = 'Activo';
                }
                $producto->save();

                $detalle->delete();

                // Recalcular totales en cabecera
                $pedido->total_pagar = $pedido->detalles()->sum('subtotal');
                $pedido->saldo_pendiente = $pedido->total_pagar;
                $pedido->save();
            });

            return redirect()->route('pedidos.detalles.index', $pedido)
                ->with('success', 'Producto eliminado y stock devuelto correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar: ' . $e->getMessage());
        }
    }
}
