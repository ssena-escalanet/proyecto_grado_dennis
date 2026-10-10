<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bitacora_acciones', function (Blueprint $table) {
            $table->id('id_bitacora');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->string('accion', 100);
            $table->string('tabla_afectada', 50);
            $table->datetime('fecha_hora');
            $table->string('ip_acceso', 45);
            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bitacora_acciones');
    }
};
