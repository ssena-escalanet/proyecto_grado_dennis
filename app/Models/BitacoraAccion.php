<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BitacoraAccion extends Model
{
    protected $table = 'bitacora_acciones';
    protected $primaryKey = 'id_bitacora';

    protected $fillable = [
        'id_usuario',
        'accion',
        'tabla_afectada',
        'fecha_hora',
        'ip_acceso'
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}
