<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->unsignedBigInteger('id_cliente');
            $table->datetime('fecha_pedido');
            $table->date('fecha_entrega_est');
            $table->decimal('total_pagar', 10, 2)->default(0);
            $table->decimal('saldo_pendiente', 10, 2)->default(0);
            $table->string('estado_pedido', 25)->default('Pendiente');
            $table->timestamps();

            $table->foreign('id_cliente')->references('id_cliente')->on('clientes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
