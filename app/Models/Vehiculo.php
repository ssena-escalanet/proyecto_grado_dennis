<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';
    protected $primaryKey = 'id_vehiculo';
    public $incrementing = true;
    
    protected $fillable = [
        'placa',
        'marca',
        'modelo',
        'capacidad_carga_kg',
        'estado'
    ];

    protected $casts = [
        'capacidad_carga_kg' => 'decimal:2'
    ];

    public function hojasDespacho()
    {
        // Uncomment when HojaDespacho model is created
        // return $this->hasMany(HojaDespacho::class, 'id_vehiculo', 'id_vehiculo');
    }
}
