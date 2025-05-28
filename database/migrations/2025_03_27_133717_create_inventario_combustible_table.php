<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     *  Crea la tabla 'inventario_combustible' para almacenar datos relacionados con el inventario de combustible.
     */
    public function up(): void
    {
        Schema::create('inventario_combustible', function (Blueprint $table) {
            $table->id();
           
            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla 'inventario_combustible' si existe.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario_combustible');
    }
};
