<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla 'historial_combustible' para registrar el historial de movimientos de combustible.
    */
    public function up(): void
    {
        // En tu archivo de migración de historial_combustible
        Schema::create('historial_combustible', function (Blueprint $table) {
            $table->id();
            $table->foreignId('combustible_id')->constrained('combustible');
            $table->decimal('cantidad_retirada', 8, 2);
            $table->string('persona');
            $table->date('fecha');
            $table->decimal('cantidad_restante', 8, 2);
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla 'historial_combustible' si existe.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_combustible');
    }
};
