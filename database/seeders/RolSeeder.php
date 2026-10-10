<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre_rol' => 'Admin', 'descripcion' => 'Acceso total al sistema'],
            ['nombre_rol' => 'Supervisor', 'descripcion' => 'Supervisa operaciones y reportes'],
            ['nombre_rol' => 'Vendedor', 'descripcion' => 'Gestiona pedidos y clientes'],
            ['nombre_rol' => 'Distribuidor', 'descripcion' => 'Gestiona entregas y rutas'],
        ];

        foreach ($roles as $rol) {
            Rol::updateOrCreate(['nombre_rol' => $rol['nombre_rol']], $rol);
        }
    }
}
