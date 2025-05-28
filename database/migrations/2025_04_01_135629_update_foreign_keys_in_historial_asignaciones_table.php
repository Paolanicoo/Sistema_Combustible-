<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
    * Modifica la tabla 'historial_asignaciones' para actualizar la clave foránea 'registro_vehicular_id'.
    */
    public function up(): void
    {
        Schema::table('historial_asignaciones', function (Blueprint $table) {
            // Elimina la restricción de clave foránea existente sobre 'registro_vehicular_id'.
            $table->dropForeign(['registro_vehicular_id']);
            
            // Crea una nueva restricción con eliminación en cascada.
            $table->foreign('registro_vehicular_id')
                ->references('id')
                ->on('registro_vehiculars')
                ->onDelete('cascade');
        });
    }

    /**
    * Revierte los cambios realizados en la migración 'up'.
    * Elimina la clave foránea con cascada y la vuelve a crear sin esa opción.
     */
    public function down(): void
    {
        Schema::table('historial_asignaciones', function (Blueprint $table) {
            // Elimina la restricción de clave foránea con cascada.
            $table->dropForeign(['registro_vehicular_id']);
            
            // Vuelve a crear la restricción sin la eliminación en cascada.
            $table->foreign('registro_vehicular_id')
                ->references('id')
                ->on('registro_vehiculars');
        });
    }
};