<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialAsignacionesTable extends Migration
{
    /**
     * Crea la tabla 'historial_asignaciones' para registrar el historial de asignaciones de vehículos.
     */
    public function up()
    {
        Schema::create('historial_asignaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_vehicular_id')->constrained('registro_vehiculars'); // Relación con la tabla registro_vehiculars
            $table->string('asignado');
            $table->timestamp('fecha_asignacion')->useCurrent();
            $table->timestamp('fecha_cambio')->nullable(); // Fecha cuando se cambió la asignación
            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla 'historial_asignaciones' si existe.
     */
    public function down()
    {
        Schema::dropIfExists('historial_asignaciones');
    }
}
