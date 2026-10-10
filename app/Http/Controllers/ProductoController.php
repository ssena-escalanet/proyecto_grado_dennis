<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\CategoriaProducto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with('categoria');

        if ($request->filled('categoria')) {
            $query->where('id_categoria', $request->categoria);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $productos = $query->paginate(10)->withQueryString();
        $categorias = CategoriaProducto::all();

        return view('pages.productos.index', compact('productos', 'categorias'))
            ->with('title', 'Gestión de Productos');
    }

    public function create()
    {
        $categorias = CategoriaProducto::all();
        return view('pages.productos.create', compact('categorias'))
            ->with('title', 'Crear Producto');
    }

    public function store(StoreProductoRequest $request)
    {
        $data = $request->validated();
        
        // RN-10: stock = 0 → estado 'Sin Stock'
        if ($data['stock_disponible'] == 0 && $data['estado'] == 'Activo') {
            $data['estado'] = 'Sin Stock';
        }

        Producto::create($data);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function show(Producto $producto)
    {
        $producto->load('categoria');
        return view('pages.productos.show', compact('producto'))
            ->with('title', 'Detalle del Producto');
    }

    public function edit(Producto $producto)
    {
        $categorias = CategoriaProducto::all();
        return view('pages.productos.edit', compact('producto', 'categorias'))
            ->with('title', 'Editar Producto');
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $data = $request->validated();

        // RN-10: stock = 0 → estado 'Sin Stock'
        if ($data['stock_disponible'] == 0 && $data['estado'] == 'Activo') {
            $data['estado'] = 'Sin Stock';
        }

        $producto->update($data);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        // RN-10: no eliminar, solo desactivar
        // Since SoftDeletes is used, delete() marks deleted_at, effectively "soft deleting".
        // But RN-10 could also mean changing status to 'Inactivo' instead of softDelete.
        // The prompt says: "softDeletes (deleted_at) — RN-10: no eliminar, solo desactivar". 
        // This usually means either just use SoftDelete, or change status. SoftDelete does both in concept. 
        // I will just use softDelete as standard CRUD.
        
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
