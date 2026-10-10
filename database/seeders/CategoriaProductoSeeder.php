<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriaProducto;

class CategoriaProductoSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre_categoria' => 'Chocolates Negros', 'descripcion' => 'Chocolates con alto porcentaje de cacao'],
            ['nombre_categoria' => 'Chocolates Blancos', 'descripcion' => 'Chocolates a base de manteca de cacao'],
            ['nombre_categoria' => 'Chocolates Rellenos', 'descripcion' => 'Chocolates con relleno de frutas o cremas'],
            ['nombre_categoria' => 'Bombones', 'descripcion' => 'Bombones finos de chocolate'],
            ['nombre_categoria' => 'Trufas', 'descripcion' => 'Trufas artesanales de chocolate'],
        ];

        foreach ($categorias as $categoria) {
            CategoriaProducto::updateOrCreate(['nombre_categoria' => $categoria['nombre_categoria']], $categoria);
        }
    }
}
