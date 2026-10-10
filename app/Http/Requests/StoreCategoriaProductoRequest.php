<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_categoria' => 'required|string|max:50|unique:categoria_producto,nombre_categoria',
            'descripcion' => 'nullable|string|max:150',
        ];
    }
}
