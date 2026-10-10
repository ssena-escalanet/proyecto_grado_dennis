<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\Cliente;
use Carbon\Carbon;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        $pedidos = [
            // Pedido 1: Cliente 1, fecha hoy, entrega en 3 días, Pendiente
            [
                'id_cliente' => 1,
                'fecha_pedido' => Carbon::now(),
                'fecha_entrega_est' => Carbon::now()->addDays(3)->toDateString(),
                'estado_pedido' => 'Pendiente',
                'total_pagar' => 0,
                'saldo_pendiente' => 0,
            ],
            // Pedido 2: Cliente 2, fecha ayer, entrega hoy, En Despacho
            [
                'id_cliente' => 2,
                'fecha_pedido' => Carbon::now()->subDays(1),
                'fecha_entrega_est' => Carbon::now()->toDateString(),
                'estado_pedido' => 'En Despacho',
                'total_pagar' => 0,
                'saldo_pendiente' => 0,
            ],
            // Pedido 3: Cliente 3, fecha hace 2 días, entrega hoy, Entregado
            [
                'id_cliente' => 3,
                'fecha_pedido' => Carbon::now()->subDays(2),
                'fecha_entrega_est' => Carbon::now()->toDateString(),
                'estado_pedido' => 'Entregado',
                'total_pagar' => 0,
                'saldo_pendiente' => 0,
            ],
            // Pedido 4: Cliente 4, fecha hace 5 días, entrega hace 2 días, Pagado
            [
                'id_cliente' => 4,
                'fecha_pedido' => Carbon::now()->subDays(5),
                'fecha_entrega_est' => Carbon::now()->subDays(2)->toDateString(),
                'estado_pedido' => 'Pagado',
                'total_pagar' => 0,
                'saldo_pendiente' => 0,
            ],
            // Pedido 5: Cliente 5, fecha hoy, entrega en 5 días, Pendiente
            [
                'id_cliente' => 5,
                'fecha_pedido' => Carbon::now(),
                'fecha_entrega_est' => Carbon::now()->addDays(5)->toDateString(),
                'estado_pedido' => 'Pendiente',
                'total_pagar' => 0,
                'saldo_pendiente' => 0,
            ],
        ];

        foreach ($pedidos as $pedido) {
            Pedido::create($pedido);
        }
    }
}
