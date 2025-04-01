<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('historial_asignaciones', function (Blueprint $table) {
            // Primero eliminar la restricción de clave foránea existente
            $table->dropForeign(['registro_vehicular_id']);
            
            // Luego crear la misma clave foránea pero con onDelete('cascade')
            $table->foreign('registro_vehicular_id')
                ->references('id')
                ->on('registro_vehiculars')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial_asignaciones', function (Blueprint $table) {
            // Revertir los cambios
            $table->dropForeign(['registro_vehicular_id']);
            
            // Volver a crear la restricción sin cascade
            $table->foreign('registro_vehicular_id')
                ->references('id')
                ->on('registro_vehiculars');
        });
    }
};