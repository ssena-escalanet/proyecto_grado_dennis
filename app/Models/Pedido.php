<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';

    protected $fillable = [
        'id_cliente', 
        'fecha_pedido', 
        'fecha_entrega_est', 
        'total_pagar', 
        'saldo_pendiente', 
        'estado_pedido'
    ];

    protected $casts = [
        'fecha_pedido' => 'datetime',
        'fecha_entrega_est' => 'date',
        'total_pagar' => 'decimal:2',
        'saldo_pendiente' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function detallePedidos()
    {
        // return $this->hasMany(DetallePedido::class, 'id_pedido', 'id_pedido');
    }

    public function detalleDespachos()
    {
        // return $this->hasMany(DetalleDespacho::class, 'id_pedido', 'id_pedido');
    }
}
