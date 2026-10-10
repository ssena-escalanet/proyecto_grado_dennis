<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detalle_despacho', function (Blueprint $table) {
            $table->id('id_detalle_despacho');
            $table->unsignedBigInteger('id_despacho');
            $table->unsignedBigInteger('id_detalle_pedido');
            $table->integer('orden_visita');
            $table->time('hora_entrega')->nullable();
            $table->string('estado_entrega', 30)->default('Pendiente');
            $table->string('motivo_rechazo', 150)->nullable();
            $table->decimal('monto_cobrado', 10, 2)->default(0);
            $table->string('observaciones', 200)->nullable();
            $table->timestamps();
            
            $table->foreign('id_despacho')->references('id_despacho')->on('hoja_despacho')->onDelete('cascade');
            $table->foreign('id_detalle_pedido')->references('id_detalle_pedido')->on('detalle_pedido');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_despacho');
    }
};
