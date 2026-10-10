<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehiculo;

class VehiculoSeeder extends Seeder
{
    public function run(): void
    {
        $vehiculos = [
            [
                'placa' => 'ABC-123',
                'marca' => 'Toyota',
                'modelo' => 'Hilux 2022',
                'capacidad_carga_kg' => 1500.00,
                'estado' => 'Disponible'
            ],
            [
                'placa' => 'DEF-456',
                'marca' => 'Nissan',
                'modelo' => 'Frontier 2021',
                'capacidad_carga_kg' => 1200.50,
                'estado' => 'Disponible'
            ],
            [
                'placa' => 'GHI-789',
                'marca' => 'Chevrolet',
                'modelo' => 'Silverado 2020',
                'capacidad_carga_kg' => 2000.00,
                'estado' => 'En Ruta'
            ],
            [
                'placa' => 'JKL-012',
                'marca' => 'Ford',
                'modelo' => 'Ranger 2019',
                'capacidad_carga_kg' => 1800.00,
                'estado' => 'Mantenimiento'
            ],
            [
                'placa' => 'MNO-345',
                'marca' => 'Mitsubishi',
                'modelo' => 'L200 2023',
                'capacidad_carga_kg' => 1300.75,
                'estado' => 'Disponible'
            ],
        ];

        foreach ($vehiculos as $vehiculo) {
            Vehiculo::updateOrCreate(['placa' => $vehiculo['placa']], $vehiculo);
        }
    }
}
