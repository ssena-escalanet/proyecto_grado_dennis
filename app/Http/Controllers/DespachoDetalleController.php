<?php

namespace App\Http\Controllers;

use App\Models\HojaDespacho;
use App\Models\DetalleDespacho;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Vehiculo;
use App\Http\Requests\StoreDespachoDetalleRequest;
use App\Http\Requests\UpdateDespachoDetalleRequest;
use Illuminate\Support\Facades\DB;

class DespachoDetalleController extends Controller
{
    public function index(HojaDespacho $despacho)
    {
        $despacho->load(['detalles.detallePedido.producto', 'detalles.detallePedido.pedido.cliente', 'vehiculo']);
        return view('pages.hoja-despacho.detalles.index', compact('despacho'))
            ->with('title', 'Hoja de Ruta / Despacho #' . $despacho->id_despacho);
    }

    public function create(HojaDespacho $despacho)
    {
        if ($despacho->estado_despacho !== 'Programado') {
            return redirect()->route('despachos.detalles.index', $despacho)
                ->with('error', 'Solo se pueden cargar pedidos a despachos Programados.');
        }

        // ACLARACIÓN 1 y 2
        $detallesDisponibles = DetallePedido::whereHas('pedido', function($q) {
                $q->where('estado_pedido', 'En Despacho');
            })
            ->whereDoesntHave('detallesDespacho')
            ->with(['producto', 'pedido.cliente'])
            ->get();

        return view('pages.hoja-despacho.detalles.create', compact('despacho', 'detallesDisponibles'))
            ->with('title', 'Cargar Pedidos al Despacho #' . $despacho->id_despacho);
    }

    public function store(StoreDespachoDetalleRequest $request, HojaDespacho $despacho)
    {
        if ($despacho->estado_despacho !== 'Programado') {
            return back()->with('error', 'El despacho ya no está Programado.');
        }

        try {
            DB::transaction(function () use ($request, $despacho) {
                $idsSeleccionados = $request->detalles;
                $vehiculo = Vehiculo::findOrFail($despacho->id_vehiculo);
                $cargaAgregada = 0;

                // Bloqueo y cálculo de peso
                $detallesPedidos = DetallePedido::with('producto')
                    ->lockForUpdate()
                    ->whereIn('id_detalle_pedido', $idsSeleccionados)
                    ->get();

                foreach ($detallesPedidos as $detalleP) {
                    $cargaAgregada += ($detalleP->cantidad * $detalleP->producto->peso_kg);
                }

                // RN-33
                if (($despacho->carga_total_kg + $cargaAgregada) > $vehiculo->capacidad_carga_kg) {
                    throw new \Exception("La carga excede la capacidad del vehículo ({$vehiculo->capacidad_carga_kg} Kg).");
                }

                $ultimoOrden = DetalleDespacho::where('id_despacho', $despacho->id_despacho)->max('orden_visita') ?? 0;

                foreach ($detallesPedidos as $detalleP) {
                    $ultimoOrden++;
                    DetalleDespacho::create([
                        'id_despacho' => $despacho->id_despacho,
                        'id_detalle_pedido' => $detalleP->id_detalle_pedido,
                        'orden_visita' => $ultimoOrden
                    ]);
                }

                $despacho->carga_total_kg += $cargaAgregada;
                $despacho->save();
            });

            return redirect()->route('despachos.detalles.index', $despacho)
                ->with('success', 'Pedidos cargados al vehículo exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(HojaDespacho $despacho, DetalleDespacho $detalle)
    {
        if ($despacho->estado_despacho === 'Completado' || $despacho->estado_despacho === 'Cancelado') {
            return back()->with('error', 'El despacho ya finalizó.');
        }

        $detalle->load('detallePedido.pedido.cliente', 'detallePedido.producto');
        return view('pages.hoja-despacho.detalles.edit', compact('despacho', 'detalle'))
            ->with('title', 'Liquidar Parada #' . $detalle->orden_visita);
    }

    public function update(UpdateDespachoDetalleRequest $request, HojaDespacho $despacho, DetalleDespacho $detalle)
    {
        try {
            DB::transaction(function () use ($request, $despacho, $detalle) {
                // MEJORA 1: Carga explícita y validación de existencia
                $detalle->load('detallePedido');
                if (!$detalle->detallePedido) {
                    throw new \Exception('El detalle de pedido asociado no existe o fue eliminado.');
                }
                
                // Bloqueo atómico del pedido cabecera
                $pedido = Pedido::lockForUpdate()->findOrFail($detalle->detallePedido->id_pedido);
                
                $estadoNuevo = $request->estado_entrega;
                $montoCobrado = 0;

                // ACLARACIÓN 4: Si se entrega, se asume cobro total del saldo
                if ($estadoNuevo === 'Entregado') {
                    $montoCobrado = $pedido->saldo_pendiente;
                }

                // Actualizar saldos y estados del Pedido
                $pedido->saldo_pendiente -= $montoCobrado;
                
                // RN-43
                if ($pedido->saldo_pendiente <= 0 && $pedido->estado_pedido !== 'Pagado') {
                    $pedido->estado_pedido = 'Pagado';
                }
                $pedido->save();

                // Liquidar el detalle del despacho
                $detalle->update([
                    'estado_entrega' => $estadoNuevo,
                    'hora_entrega' => $request->hora_entrega,
                    'motivo_rechazo' => $request->motivo_rechazo,
                    'monto_cobrado' => $montoCobrado,
                    'observaciones' => $request->observaciones
                ]);

                // Auto-cierre si todo está liquidado
                $pendientes = DetalleDespacho::where('id_despacho', $despacho->id_despacho)
                                ->where('estado_entrega', 'Pendiente')
                                ->count();
                                
                if ($pendientes === 0) {
                    $despacho->estado_despacho = 'Completado';
                    $despacho->hora_llegada = now()->format('H:i:s');
                    $despacho->save();

                    // Liberar vehículo
                    $vehiculo = Vehiculo::find($despacho->id_vehiculo);
                    if ($vehiculo && $vehiculo->estado === 'En Ruta') {
                        $vehiculo->estado = 'Disponible';
                        $vehiculo->save();
                    }
                }
            });

            return redirect()->route('despachos.detalles.index', $despacho)
                ->with('success', 'Parada liquidada exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al liquidar: ' . $e->getMessage());
        }
    }

    public function destroy(HojaDespacho $despacho, DetalleDespacho $detalle)
    {
        if ($detalle->estado_entrega !== 'Pendiente') {
            return back()->with('error', 'No se puede quitar una parada que ya fue liquidada.');
        }

        try {
            DB::transaction(function () use ($despacho, $detalle) {
                // Restar peso
                $detalle->load('detallePedido.producto');
                $pesoDescontado = $detalle->detallePedido->cantidad * $detalle->detallePedido->producto->peso_kg;
                
                $despacho->carga_total_kg -= $pesoDescontado;
                $despacho->save();
                
                $detalle->delete();
            });

            return back()->with('success', 'Parada removida de la ruta.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al remover la parada: ' . $e->getMessage());
        }
    }
}
