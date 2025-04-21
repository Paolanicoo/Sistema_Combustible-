<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('combustible', function (Blueprint $table) {
            $table->id();
            $table->date('fecha'); // Nueva columna para la fecha
            $table->decimal('cantidad_entrada', 8, 2); // Nueva columna para cantidad inicial
            $table->decimal('cantidad_actual', 8, 2);  // Columna para cantidad actual
            $table->string('descripcion', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combustible');
    }
};
