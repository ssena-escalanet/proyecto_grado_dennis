<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehiculoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'placa' => 'required|string|max:15|unique:vehiculos,placa',
            'marca' => 'required|string|max:40',
            'modelo' => 'required|string|max:40',
            'capacidad_carga_kg' => 'required|numeric|min:0.01',
            'estado' => 'required|in:Disponible,En Ruta,Mantenimiento',
        ];
    }
}
