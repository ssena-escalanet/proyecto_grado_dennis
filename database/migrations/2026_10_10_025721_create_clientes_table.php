<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('id_cliente');
            $table->string('nombre_negocio', 100);
            $table->string('representante', 100);
            $table->string('nit_ci', 25)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 150);
            $table->decimal('coordenada_lat', 10, 7)->nullable();
            $table->decimal('coordenada_lon', 10, 7)->nullable();
            $table->string('estado', 20)->default('Activo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
