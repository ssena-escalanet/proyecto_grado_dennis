<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    use HasFactory;

    protected $table = 'categoria_producto';
    protected $primaryKey = 'id_categoria';
    public $incrementing = true;
    
    protected $fillable = [
        'nombre_categoria',
        'descripcion'
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria', 'id_categoria');
    }
}
