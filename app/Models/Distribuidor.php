<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribuidor extends Model
{
    use HasFactory;

    protected $table = 'distribuidores';
    protected $primaryKey = 'id_distribuidor';
    public $incrementing = true;
    
    protected $fillable = [
        'nombres',
        'apellidos',
        'ci',
        'licencia_conducir',
        'telefono',
        'estado'
    ];

    public function hojasDespacho()
    {
        // Uncomment when HojaDespacho model is created
        // return $this->hasMany(HojaDespacho::class, 'id_distribuidor', 'id_distribuidor');
    }
}
