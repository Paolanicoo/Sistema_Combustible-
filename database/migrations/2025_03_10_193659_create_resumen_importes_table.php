<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla 'resumen_importes' para almacenar los totales de importes asociados a vehículos y combustibles.
     */
    public function up(): void
    {
        Schema::create('resumen_importes', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('total', 10, 2);
            $table->string('empresa');
            $table->unsignedBigInteger('id_registro_vehicular');
            $table->unsignedBigInteger('id_registro_combustible');
            $table->string('cog');
            $table->timestamps();

            // Clave foránea con eliminación en cascada (se elimina si se borra en combustibles)
            $table->foreign('id_registro_combustible')
             ->references('id')->on('registro_combustibles')
             ->onDelete('cascade');
        });
    }

    /**
     * Elimina la clave foránea y luego la tabla 'resumen_importes' si existe.
     */
    public function down(): void
    {
        // Elimina la clave foránea antes de eliminar la tabla para evitar errores.
        Schema::table('resumen_importes', function (Blueprint $table) {
            $table->dropForeign(['id_registro_combustible']);
        });

        Schema::dropIfExists('resumen_importes');
    }
};
