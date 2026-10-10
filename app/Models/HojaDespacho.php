<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HojaDespacho extends Model
{
    protected $table = 'hoja_despacho';
    protected $primaryKey = 'id_despacho';

    protected $fillable = [
        'id_distribuidor', 
        'id_vehiculo', 
        'fecha_despacho', 
        'hora_salida', 
        'hora_llegada', 
        'kilometraje_inicial', 
        'kilometraje_final', 
        'carga_total_kg', 
        'estado_despacho'
    ];

    protected $casts = [
        'fecha_despacho' => 'date',
        'carga_total_kg' => 'decimal:2',
    ];

    public function distribuidor()
    {
        return $this->belongsTo(Distribuidor::class, 'id_distribuidor', 'id_distribuidor');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo', 'id_vehiculo');
    }

    public function detalleDespachos()
    {
        // return $this->hasMany(DetalleDespacho::class, 'id_despacho', 'id_despacho');
    }
}
