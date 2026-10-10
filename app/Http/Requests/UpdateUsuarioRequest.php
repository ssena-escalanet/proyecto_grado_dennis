<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
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
            'username' => 'required|string|max:50|unique:usuarios,username,' . $this->usuario->id_usuario . ',id_usuario',
            'email' => 'required|email|max:100|unique:usuarios,email,' . $this->usuario->id_usuario . ',id_usuario',
            'id_rol' => 'required|exists:roles,id_rol',
            'estado' => 'required|in:Activo,Inactivo',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
}
