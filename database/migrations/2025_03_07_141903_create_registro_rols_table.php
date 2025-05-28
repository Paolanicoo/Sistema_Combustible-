<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla 'registro_rols' para almacenar información de los roles.
     */
    public function up(): void
    {
        Schema::create('registro_rols', function (Blueprint $table) {
            $table->id();
            $table->string('rol');
            $table->boolean('estado')->default(true); // true = activo, false = inactivo
            $table->timestamps();
        });
    }

    /**
    * Elimina la tabla 'registro_rols' si existe.
    */
    public function down(): void
    {
        Schema::dropIfExists('registro_rols');
    }
};
