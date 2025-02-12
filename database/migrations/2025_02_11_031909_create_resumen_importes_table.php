<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('resumen_importes', function (Blueprint $table) {
            $table->id();
            $table->string('mes')->after('id'); // Agrega la columna
            $table->decimal('precio', '10.2');
            $table->decimal('total', '10.2');
            $table->string('empresa');
            $table->string('costo');
            $table->string('gasto');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resumen_importes');
    }
};
