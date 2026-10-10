<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHojaDespachoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_distribuidor' => 'required|exists:distribuidores,id_distribuidor',
            'id_vehiculo' => 'required|exists:vehiculos,id_vehiculo',
            'fecha_despacho' => 'required|date',
            'hora_salida' => 'required|date_format:H:i',
            'hora_llegada' => 'nullable|date_format:H:i|after:hora_salida',
            'kilometraje_inicial' => 'required|integer|min:0',
            'kilometraje_final' => 'nullable|integer|gte:kilometraje_inicial',
            'estado_despacho' => 'required|in:Programado,En Ruta,Completado,Cancelado',
        ];
    }
}
