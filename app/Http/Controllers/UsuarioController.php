<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('rol')->paginate(10);
        return view('pages.usuarios.index', compact('usuarios'))
            ->with('title', 'Gestión de Usuarios');
    }

    public function create()
    {
        $roles = Rol::all();
        return view('pages.usuarios.create', compact('roles'))
            ->with('title', 'Crear Usuario');
    }

    public function store(StoreUsuarioRequest $request)
    {
        $data = $request->validated();
        $data['password_hash'] = Hash::make($data['password']);
        unset($data['password'], $data['password_confirmation']);

        User::create($data);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show(User $usuario)
    {
        $usuario->load('rol');
        return view('pages.usuarios.show', compact('usuario'))
            ->with('title', 'Detalle del Usuario');
    }

    public function edit(User $usuario)
    {
        $roles = Rol::all();
        return view('pages.usuarios.edit', compact('usuario', 'roles'))
            ->with('title', 'Editar Usuario');
    }

    public function update(UpdateUsuarioRequest $request, User $usuario)
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password_hash'] = Hash::make($data['password']);
        }
        unset($data['password'], $data['password_confirmation']);

        $usuario->update($data);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        // RN-47: No eliminar el último Admin activo
        if ($usuario->id_rol == 1) {
            $adminsActivos = User::where('id_rol', 1)
                ->where('estado', 'Activo')
                ->count();

            if ($adminsActivos <= 1) {
                return redirect()->route('usuarios.index')
                    ->with('error', 'No se puede eliminar el último administrador del sistema.');
            }
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
