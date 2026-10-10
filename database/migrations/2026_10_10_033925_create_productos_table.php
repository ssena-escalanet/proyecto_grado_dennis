<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->unsignedBigInteger('id_categoria');
            $table->string('nombre_producto', 80);
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('peso_kg', 8, 3);
            $table->integer('stock_disponible')->default(0);
            $table->string('estado', 20)->default('Activo');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_categoria')->references('id_categoria')->on('categoria_producto');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
