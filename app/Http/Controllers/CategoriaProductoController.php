<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProducto;
use App\Http\Requests\StoreCategoriaProductoRequest;
use App\Http\Requests\UpdateCategoriaProductoRequest;

class CategoriaProductoController extends Controller
{
    public function index()
    {
        $categorias = CategoriaProducto::paginate(10);
        return view('pages.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('pages.categorias.create');
    }

    public function store(StoreCategoriaProductoRequest $request)
    {
        CategoriaProducto::create($request->validated());
        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function show(CategoriaProducto $categoria)
    {
        return view('pages.categorias.show', compact('categoria'));
    }

    public function edit(CategoriaProducto $categoria)
    {
        return view('pages.categorias.edit', compact('categoria'));
    }

    public function update(UpdateCategoriaProductoRequest $request, CategoriaProducto $categoria)
    {
        $categoria->update($request->validated());
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(CategoriaProducto $categoria)
    {
        // RN-02: Prevent deletion if products exist
        // Uncomment once Producto model exists
        // if ($categoria->productos()->exists()) {
        //     return redirect()->route('categorias.index')->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
        // }
        
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
