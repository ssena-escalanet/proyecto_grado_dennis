<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';
    public $incrementing = true;
    
    protected $fillable = [
        'nombre_negocio',
        'representante',
        'nit_ci',
        'telefono',
        'direccion',
        'coordenada_lat',
        'coordenada_lon',
        'estado'
    ];

    protected $casts = [
        'coordenada_lat' => 'decimal:7',
        'coordenada_lon' => 'decimal:7'
    ];

    public function pedidos()
    {
        // Uncomment when Pedido model is created
        // return $this->hasMany(Pedido::class, 'id_cliente', 'id_cliente');
    }
}
