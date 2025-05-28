<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroVehicular extends Model
{
    // Se incluye el trait HasFactory para permitir la creación de registros con factories (útil en los seeders).
    use HasFactory;
    
    // Se define qué columnas pueden ser asignadas masivamente.
    protected $fillable = [
        'equipo',
        'marca',
        'placa',
        'modelo',
        'motor',
        'serie',
        'asignado',
        'observacion',
    ];

    // Se define una relación uno a muchos: un vehículo puede tener muchos registros de combustible.
    public function combsutible() {
        return $this->hasMany(RegistroCombustible::class,'id_registro_combustible', 'id');
    }

    // Se define una relación uno a muchos: un vehículo puede tener muchos resúmenes de importes asociados.
    public function importes() {
        return $this->hasMany(ResumenImporte::class, 'id_registro_vehicular', 'id');
    }
    
    // Se define una relación inversa: este modelo pertenece a un resumen de importe.
    // Asegúrate de tener las relaciones bien definidas en el modelo RegistroVehicular.
    public function vehiculo() {
        return $this->belongsTo(ResumenImporte::class, 'id_registro_vehicular', 'id');
    }

}
