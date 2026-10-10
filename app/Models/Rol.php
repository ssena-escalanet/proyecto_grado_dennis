<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id_rol';
    public $incrementing = true;
    
    protected $fillable = [
        'nombre_rol',
        'descripcion'
    ];

    public function usuarios()
    {
        // Esto asume que tienes un modelo Usuario, si no existe lo crearemos luego.
        return $this->hasMany(Usuario::class, 'id_rol');
    }
}
