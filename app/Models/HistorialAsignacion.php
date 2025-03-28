<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialAsignacion extends Model
{
    use HasFactory;

    protected $table = 'historial_asignaciones'; // Agregar esta línea

    protected $fillable = ['registro_vehicular_id', 'asignado'];

    public function registroVehicular()
    {
        return $this->belongsTo(RegistroVehicular::class);
    }
}