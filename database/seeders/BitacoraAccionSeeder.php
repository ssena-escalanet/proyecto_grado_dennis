<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BitacoraAccion;
use Carbon\Carbon;

class BitacoraAccionSeeder extends Seeder
{
    public function run(): void
    {
        $bitacoras = [
            // 3 Crear para productos
            ['id_usuario' => 1, 'accion' => 'Crear', 'tabla_afectada' => 'productos', 'fecha_hora' => Carbon::now()->subDays(6)->subHours(2), 'ip_acceso' => '192.168.1.10'],
            ['id_usuario' => 1, 'accion' => 'Crear', 'tabla_afectada' => 'productos', 'fecha_hora' => Carbon::now()->subDays(5)->subHours(4), 'ip_acceso' => '192.168.1.10'],
            ['id_usuario' => 1, 'accion' => 'Crear', 'tabla_afectada' => 'productos', 'fecha_hora' => Carbon::now()->subDays(4)->subHours(1), 'ip_acceso' => '192.168.1.15'],
            // 2 Editar para clientes
            ['id_usuario' => 1, 'accion' => 'Editar', 'tabla_afectada' => 'clientes', 'fecha_hora' => Carbon::now()->subDays(3)->subHours(5), 'ip_acceso' => '192.168.1.12'],
            ['id_usuario' => 1, 'accion' => 'Editar', 'tabla_afectada' => 'clientes', 'fecha_hora' => Carbon::now()->subDays(2)->subHours(3), 'ip_acceso' => '192.168.1.12'],
            // 2 Eliminar para vehiculos
            ['id_usuario' => 1, 'accion' => 'Eliminar', 'tabla_afectada' => 'vehiculos', 'fecha_hora' => Carbon::now()->subDays(1)->subHours(7), 'ip_acceso' => '192.168.1.10'],
            ['id_usuario' => 1, 'accion' => 'Eliminar', 'tabla_afectada' => 'vehiculos', 'fecha_hora' => Carbon::now()->subHours(8), 'ip_acceso' => '192.168.1.15'],
            // 3 Crear para usuarios
            ['id_usuario' => 1, 'accion' => 'Crear', 'tabla_afectada' => 'usuarios', 'fecha_hora' => Carbon::now()->subHours(6), 'ip_acceso' => '127.0.0.1'],
            ['id_usuario' => 1, 'accion' => 'Crear', 'tabla_afectada' => 'usuarios', 'fecha_hora' => Carbon::now()->subHours(4), 'ip_acceso' => '127.0.0.1'],
            ['id_usuario' => 1, 'accion' => 'Crear', 'tabla_afectada' => 'usuarios', 'fecha_hora' => Carbon::now()->subHours(1), 'ip_acceso' => '127.0.0.1'],
        ];

        foreach ($bitacoras as $b) {
            BitacoraAccion::create($b);
        }
    }
}
