<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\CategoriaProducto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // Categorías esperadas (asegúrate de que los IDs coincidan, asumiendo 1 a 5 según el orden):
        // 1: Chocolates Negros
        // 2: Chocolates Blancos
        // 3: Chocolates Rellenos
        // 4: Bombones
        // 5: Trufas
        
        $productos = [
            // Chocolates Negros (id_categoria = 1)
            [
                'id_categoria' => 1,
                'nombre_producto' => 'Chocolate Negro 70% Cacao',
                'precio_unitario' => 15.50,
                'peso_kg' => 0.100,
                'stock_disponible' => 150,
                'estado' => 'Activo'
            ],
            [
                'id_categoria' => 1,
                'nombre_producto' => 'Chocolate Negro 85% Intenso',
                'precio_unitario' => 18.00,
                'peso_kg' => 0.100,
                'stock_disponible' => 80,
                'estado' => 'Activo'
            ],
            // Chocolates Blancos (id_categoria = 2)
            [
                'id_categoria' => 2,
                'nombre_producto' => 'Chocolate Blanco con Vainilla',
                'precio_unitario' => 12.00,
                'peso_kg' => 0.100,
                'stock_disponible' => 200,
                'estado' => 'Activo'
            ],
            [
                'id_categoria' => 2,
                'nombre_producto' => 'Chocolate Blanco con Almendras',
                'precio_unitario' => 14.50,
                'peso_kg' => 0.120,
                'stock_disponible' => 100,
                'estado' => 'Activo'
            ],
            // Chocolates Rellenos (id_categoria = 3)
            [
                'id_categoria' => 3,
                'nombre_producto' => 'Chocolate Relleno de Fresa',
                'precio_unitario' => 16.00,
                'peso_kg' => 0.150,
                'stock_disponible' => 90,
                'estado' => 'Activo'
            ],
            [
                'id_categoria' => 3,
                'nombre_producto' => 'Chocolate Relleno de Caramelo',
                'precio_unitario' => 16.50,
                'peso_kg' => 0.150,
                'stock_disponible' => 0,
                'estado' => 'Sin Stock'
            ],
            // Bombones (id_categoria = 4)
            [
                'id_categoria' => 4,
                'nombre_producto' => 'Caja de Bombones Surtidos',
                'precio_unitario' => 45.00,
                'peso_kg' => 0.500,
                'stock_disponible' => 50,
                'estado' => 'Activo'
            ],
            [
                'id_categoria' => 4,
                'nombre_producto' => 'Bombones de Licor',
                'precio_unitario' => 50.00,
                'peso_kg' => 0.400,
                'stock_disponible' => 30,
                'estado' => 'Activo'
            ],
            // Trufas (id_categoria = 5)
            [
                'id_categoria' => 5,
                'nombre_producto' => 'Trufas Clásicas de Cacao',
                'precio_unitario' => 35.00,
                'peso_kg' => 0.250,
                'stock_disponible' => 60,
                'estado' => 'Activo'
            ],
            [
                'id_categoria' => 5,
                'nombre_producto' => 'Trufas Blancas de Coco',
                'precio_unitario' => 38.00,
                'peso_kg' => 0.250,
                'stock_disponible' => 40,
                'estado' => 'Activo'
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
