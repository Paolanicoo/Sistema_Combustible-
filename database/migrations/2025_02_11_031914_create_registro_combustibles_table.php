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
            $table->integer('factura');
            $table->unsignedBigInteger('id_registro_vehicular');
            $table->integer('e_galones')->nullable();
            $table->integer('s_galones');

            $table->timestamps();

            $table->foreign('id_registro_vehicular')->references('id')->on('registro_vehicular')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('registro_combustibles');
    }
};
