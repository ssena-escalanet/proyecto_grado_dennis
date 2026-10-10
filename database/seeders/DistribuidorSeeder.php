<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Distribuidor;

class DistribuidorSeeder extends Seeder
{
    public function run(): void
    {
        $distribuidores = [
            [
                'nombres' => 'Juan Carlos',
                'apellidos' => 'Pérez Gómez',
                'ci' => '8765432 LP',
                'licencia_conducir' => 'A-1234567',
                'telefono' => '+591 700-12345',
                'estado' => 'Activo'
            ],
            [
                'nombres' => 'María Fernanda',
                'apellidos' => 'Quispe Mamani',
                'ci' => '7654321 CB',
                'licencia_conducir' => 'B-2345678',
                'telefono' => '+591 701-23456',
                'estado' => 'Activo'
            ],
            [
                'nombres' => 'Roberto Carlos',
                'apellidos' => 'Flores Villarroel',
                'ci' => '6543210 SC',
                'licencia_conducir' => 'A-3456789',
                'telefono' => '+591 702-34567',
                'estado' => 'Activo'
            ],
            [
                'nombres' => 'Ana Lucía',
                'apellidos' => 'Gutiérrez Rojas',
                'ci' => '5432109 OR',
                'licencia_conducir' => 'C-4567890',
                'telefono' => '+591 703-45678',
                'estado' => 'En Ruta'
            ],
            [
                'nombres' => 'Pedro Antonio',
                'apellidos' => 'Mamani Condori',
                'ci' => '4321098 PT',
                'licencia_conducir' => 'A-5678901',
                'telefono' => '+591 704-56789',
                'estado' => 'Inactivo'
            ],
        ];

        foreach ($distribuidores as $distribuidor) {
            Distribuidor::updateOrCreate(['ci' => $distribuidor['ci']], $distribuidor);
        }
    }
}
