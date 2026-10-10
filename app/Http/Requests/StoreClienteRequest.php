<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_negocio' => 'required|string|max:100',
            'representante' => 'required|string|max:100',
            'nit_ci' => 'required|string|max:25|unique:clientes,nit_ci',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'required|string|max:150',
            'coordenada_lat' => 'nullable|numeric|between:-90,90|required_with:coordenada_lon',
            'coordenada_lon' => 'nullable|numeric|between:-180,180|required_with:coordenada_lat',
            'estado' => 'nullable|in:Activo,Inactivo',
        ];
    }
}
