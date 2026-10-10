<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::paginate(10);
        return view('pages.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('pages.clientes.create');
    }

    public function store(StoreClienteRequest $request)
    {
        $data = $request->validated();
        if (empty($data['estado'])) {
            $data['estado'] = 'Activo';
        }
        Cliente::create($data);
        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function show(Cliente $cliente)
    {
        return view('pages.clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('pages.clientes.edit', compact('cliente'));
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $data = $request->validated();
        if (empty($data['estado'])) {
            $data['estado'] = 'Activo';
        }
        $cliente->update($data);
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Cliente $cliente)
    {
        // RN-13: SoftDelete (siempre mantenemos el registro histórico)
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado (desactivado) exitosamente.');
    }
}
