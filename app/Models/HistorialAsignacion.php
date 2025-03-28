<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialAsignacion extends Model
{
    use HasFactory;

    protected $fillable = ['registro_vehicular_id', 'asignado', 'fecha_asignacion', 'fecha_cambio'];

    // Relación con RegistroVehicular
    public function registroVehicular()
    {
        return $this->belongsTo(RegistroVehicular::class);
    }
}
