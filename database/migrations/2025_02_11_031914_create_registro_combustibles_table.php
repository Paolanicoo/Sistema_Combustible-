<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('registro_combustibles', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('num_factura');
            $table->unsignedBigInteger('id_registro_vehicular');
            $table->integer('entradas')->nullable();
            $table->integer('salidas')->nullable();
            $table->integer('precio');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('registro_combustibles');
    }
};
