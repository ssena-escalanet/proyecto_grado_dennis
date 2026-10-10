<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribuidores', function (Blueprint $table) {
            $table->id('id_distribuidor');
            $table->string('nombres', 60);
            $table->string('apellidos', 60);
            $table->string('ci', 20)->unique();
            $table->string('licencia_conducir', 20);
            $table->string('telefono', 20)->nullable();
            $table->string('estado', 20)->default('Activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribuidores');
    }
};
