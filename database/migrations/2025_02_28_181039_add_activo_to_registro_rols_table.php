<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('registro_rols', function (Blueprint $table) {
            $table->boolean('activo')->default(true);  // Agrega la columna 'activo' como booleano
        });
    }

    public function down()
    {
        Schema::table('registro_rols', function (Blueprint $table) {
            $table->dropColumn('activo');  // Eliminar la columna si se hace un rollback
        });
    }
};
