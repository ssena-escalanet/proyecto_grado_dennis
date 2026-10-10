<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HojaDespacho;
use Carbon\Carbon;

class HojaDespachoSeeder extends Seeder
{
    public function run(): void
    {
        $despachos = [
            // Despacho 1: Distribuidor 1, Vehículo 1, hoy, salida 08:00, km_ini 1000, Programado
            [
                'id_distribuidor' => 1,
                'id_vehiculo' => 1,
                'fecha_despacho' => Carbon::now()->toDateString(),
                'hora_salida' => '08:00',
                'hora_llegada' => null,
                'kilometraje_inicial' => 1000,
                'kilometraje_final' => null,
                'estado_despacho' => 'Programado',
                'carga_total_kg' => 0,
            ],
            // Despacho 2: Distribuidor 2, Vehículo 2, ayer, salida 09:00, llegada 17:00, km_ini 2000, km_fin 2150, Completado
            [
                'id_distribuidor' => 2,
                'id_vehiculo' => 2,
                'fecha_despacho' => Carbon::now()->subDays(1)->toDateString(),
                'hora_salida' => '09:00',
                'hora_llegada' => '17:00',
                'kilometraje_inicial' => 2000,
                'kilometraje_final' => 2150,
                'estado_despacho' => 'Completado',
                'carga_total_kg' => 0,
            ],
            // Despacho 3: Distribuidor 3, Vehículo 3, hace 2 días, salida 10:00, llegada 18:00, km_ini 3000, km_fin 3200, Completado
            [
                'id_distribuidor' => 3,
                'id_vehiculo' => 3,
                'fecha_despacho' => Carbon::now()->subDays(2)->toDateString(),
                'hora_salida' => '10:00',
                'hora_llegada' => '18:00',
                'kilometraje_inicial' => 3000,
                'kilometraje_final' => 3200,
                'estado_despacho' => 'Completado',
                'carga_total_kg' => 0,
            ],
            // Despacho 4: Distribuidor 4, Vehículo 4, hoy, salida 07:00, km_ini 5000, En Ruta
            [
                'id_distribuidor' => 4,
                'id_vehiculo' => 4,
                'fecha_despacho' => Carbon::now()->toDateString(),
                'hora_salida' => '07:00',
                'hora_llegada' => null,
                'kilometraje_inicial' => 5000,
                'kilometraje_final' => null,
                'estado_despacho' => 'En Ruta',
                'carga_total_kg' => 0,
            ],
            // Despacho 5: Distribuidor 5, Vehículo 5, mañana, salida 08:30, km_ini 6000, Programado
            [
                'id_distribuidor' => 5,
                'id_vehiculo' => 5,
                'fecha_despacho' => Carbon::now()->addDays(1)->toDateString(),
                'hora_salida' => '08:30',
                'hora_llegada' => null,
                'kilometraje_inicial' => 6000,
                'kilometraje_final' => null,
                'estado_despacho' => 'Programado',
                'carga_total_kg' => 0,
            ],
        ];

        foreach ($despachos as $despacho) {
            HojaDespacho::create($despacho);
        }
    }
}
