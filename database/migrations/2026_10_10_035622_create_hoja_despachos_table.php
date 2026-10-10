<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hoja_despacho', function (Blueprint $table) {
            $table->id('id_despacho');
            $table->unsignedBigInteger('id_distribuidor');
            $table->unsignedBigInteger('id_vehiculo');
            $table->date('fecha_despacho');
            $table->time('hora_salida');
            $table->time('hora_llegada')->nullable();
            $table->unsignedInteger('kilometraje_inicial');
            $table->unsignedInteger('kilometraje_final')->nullable();
            $table->decimal('carga_total_kg', 8, 2)->default(0);
            $table->string('estado_despacho', 25)->default('Programado');
            $table->timestamps();

            $table->foreign('id_distribuidor')->references('id_distribuidor')->on('distribuidores');
            $table->foreign('id_vehiculo')->references('id_vehiculo')->on('vehiculos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hoja_despacho');
    }
};
