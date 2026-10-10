<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleDespacho extends Model
{
    protected $table = 'detalle_despacho';
    protected $primaryKey = 'id_detalle_despacho';

    protected $fillable = [
        'id_despacho', 'id_detalle_pedido', 'orden_visita', 'hora_entrega', 
        'estado_entrega', 'motivo_rechazo', 'monto_cobrado', 'observaciones'
    ];

    protected $casts = [
        'hora_entrega' => 'datetime:H:i',
    ];

    public function hojaDespacho()
    {
        return $this->belongsTo(HojaDespacho::class, 'id_despacho', 'id_despacho');
    }

    public function detallePedido()
    {
        return $this->belongsTo(DetallePedido::class, 'id_detalle_pedido', 'id_detalle_pedido');
    }
}
