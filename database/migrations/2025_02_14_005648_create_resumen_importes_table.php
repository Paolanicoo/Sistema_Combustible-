<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resumen_importes', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 10, 2);
            $table->unsignedBigInteger('id_registro_vehicular');
            $table->unsignedBigInteger('id_registro_combustible');
            $table->string('cog');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumen_importes');
    }
};
