<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla 'users' para almacenar la información de los usuarios del sistema.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('password');
            $table->string('role');
            $table->boolean('is_protected')->default(false); // Campo agregado para proteger usuarios
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla 'users' si existe.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};