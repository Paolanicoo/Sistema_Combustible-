<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialAsignacion extends Model
{
    // Se incluye el trait HasFactory para permitir la creación de registros con factories (útil en los seeders).
    use HasFactory;

    // Se especifica el nombre de la tabla en la base de datos asociada a este modelo.
    protected $table = 'historial_asignaciones'; 

    // Se define qué columnas pueden ser asignadas masivamente.
    protected $fillable = ['registro_vehicular_id', 'asignado'];

     // Se define una relación inversa: este historial pertenece a un registro vehicular.
    public function registroVehicular()
    {
        return $this->belongsTo(RegistroVehicular::class);
    }
}