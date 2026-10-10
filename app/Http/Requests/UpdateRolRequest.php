<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_rol' => 'required|string|max:40|unique:roles,nombre_rol,' . $this->route('role')->id_rol . ',id_rol',
            'descripcion' => 'nullable|string|max:100',
        ];
    }
}
