<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $fillable = [
        'id_categoria',
        'nombre_producto',
        'precio_unitario',
        'peso_kg',
        'stock_disponible',
        'estado'
    ];
    
    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'peso_kg' => 'decimal:3'
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaProducto::class, 'id_categoria', 'id_categoria');
    }

    public function detallePedidos()
    {
        // hasMany(DetallePedido::class, 'id_producto', 'id_producto')
        // Se comentará hasta crear el modelo DetallePedido o se deja el prototipo
    }
}
