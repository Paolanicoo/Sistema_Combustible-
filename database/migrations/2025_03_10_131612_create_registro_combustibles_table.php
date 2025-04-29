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
            $table->string('tipo')->nullable(); 
            $table->decimal('entradas', 10, 4)->nullable();  
            $table->decimal('salidas', 10, 4)->nullable();  
            $table->decimal('precio', 10, 2); 
            $table->string('observacion')->nullable();  
            $table->timestamps();

             // Clave foránea
             $table->foreign('id_registro_vehicular')->references('id')->on('registro_vehiculars')->onDelete('cascade');
             
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registro_combustibles');
    }
};
