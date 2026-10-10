<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_categoria' => 'required|exists:categoria_producto,id_categoria',
            'nombre_producto' => 'required|string|max:80',
            'precio_unitario' => 'required|numeric|min:0.01',
            'peso_kg' => 'required|numeric|min:0.001',
            'stock_disponible' => 'required|integer|min:0',
            'estado' => 'required|in:Activo,Inactivo,Sin Stock',
        ];
    }
}
