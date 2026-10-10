<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'nombre_negocio' => 'Distribuidora El Sol',
                'representante' => 'Juan Pérez',
                'nit_ci' => '1234567015',
                'telefono' => '71234567',
                'direccion' => 'Calle Sagárnaga #123, La Paz',
                'coordenada_lat' => -16.5000000,
                'coordenada_lon' => -68.1500000,
                'estado' => 'Activo'
            ],
            [
                'nombre_negocio' => 'Supermercados Andinos',
                'representante' => 'María López',
                'nit_ci' => '9876543011',
                'telefono' => '72345678',
                'direccion' => 'Av. San Martín #456, Equipetrol, Santa Cruz',
                'coordenada_lat' => -17.7833270,
                'coordenada_lon' => -63.1821400,
                'estado' => 'Activo'
            ],
            [
                'nombre_negocio' => 'Tienda Doña Rosa',
                'representante' => 'Rosa Gutiérrez',
                'nit_ci' => '5432167012',
                'telefono' => '73456789',
                'direccion' => 'Av. Heroínas #789, Cochabamba',
                'coordenada_lat' => -17.3895000,
                'coordenada_lon' => -66.1568000,
                'estado' => 'Activo'
            ],
            [
                'nombre_negocio' => 'Minimarket Central',
                'representante' => 'Carlos Mendoza',
                'nit_ci' => '3456789013',
                'telefono' => '74567890',
                'direccion' => 'Calle Calvo #321, Sucre',
                'coordenada_lat' => -19.0333330,
                'coordenada_lon' => -65.2627410,
                'estado' => 'Activo'
            ],
            [
                'nombre_negocio' => 'Almacén Los Andes',
                'representante' => 'Ana Condori',
                'nit_ci' => '7654321014',
                'telefono' => '75678901',
                'direccion' => 'Calle Bolívar #654, Oruro',
                'coordenada_lat' => -17.9833330,
                'coordenada_lon' => -67.1500000,
                'estado' => 'Activo'
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::updateOrCreate(['nit_ci' => $cliente['nit_ci']], $cliente);
        }
    }
}
