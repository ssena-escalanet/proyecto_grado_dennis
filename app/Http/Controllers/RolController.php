<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Http\Requests\StoreRolRequest;
use App\Http\Requests\UpdateRolRequest;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::paginate(10);
        return view('pages.roles.index', ['title' => 'Gestión de Roles', 'roles' => $roles]);
    }

    public function create()
    {
        return view('pages.roles.create', ['title' => 'Crear Rol']);
    }

    public function store(StoreRolRequest $request)
    {
        Rol::create($request->validated());
        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function show(Rol $role)
    {
        return view('pages.roles.show', ['title' => 'Detalle del Rol', 'rol' => $role]);
    }

    public function edit(Rol $role)
    {
        return view('pages.roles.edit', ['title' => 'Editar Rol', 'rol' => $role]);
    }

    public function update(UpdateRolRequest $request, Rol $role)
    {
        $role->update($request->validated());
        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Rol $role)
    {
        // Evita el error temporalmente si la clase Usuario no existe
        if (method_exists($role, 'usuarios') && class_exists('App\Models\Usuario')) {
            if ($role->usuarios()->exists()) {
                return redirect()->route('roles.index')->with('error', 'No se puede eliminar el rol porque tiene usuarios asociados.');
            }
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}
