<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('registro_vehiculars', function (Blueprint $table) {
            $table->id();
            $table->string('equipo');
            $table->string('marca');
            $table->string('placa');
            $table->string('modelo');
            $table->string('motor');
            $table->string('serie');
            $table->string('asignado');
            $table->string('observacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registro_vehiculars');
    }
};
