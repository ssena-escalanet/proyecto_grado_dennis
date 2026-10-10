<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDistribuidorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres' => 'required|string|max:60',
            'apellidos' => 'required|string|max:60',
            'ci' => 'required|string|max:20|unique:distribuidores,ci,' . $this->distribuidor->id_distribuidor . ',id_distribuidor',
            'licencia_conducir' => 'required|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'estado' => 'required|in:Activo,Inactivo,En Ruta',
        ];
    }
}
