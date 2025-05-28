<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla 'registro_vehiculars' para almacenar información de vehículos registrados.
     */
    public function up(): void
    {
        Schema::create('registro_vehiculars', function (Blueprint $table) {
            $table->id();
            $table->string('equipo');
            $table->string('marca')->nullable();;
            $table->string('placa')->nullable();;
            $table->string('modelo')->nullable();;
            $table->string('motor')->nullable();;
            $table->string('serie')->nullable();;
            $table->string('asignado');
            $table->string('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
    * Elimina la tabla 'registro_vehiculars' si existe.
    */
    public function down(): void
    {
        Schema::dropIfExists('registro_vehiculars');
    }
};
