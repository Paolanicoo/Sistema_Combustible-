<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumenImporte extends Model
{
    // Se incluye el trait HasFactory para permitir la creación de registros con factories (útil en los seeders).
    use HasFactory;

    // Se especifica el nombre de la tabla en la base de datos asociada a este modelo.
    protected $table = 'resumen_importes'; 

    // Se define qué columnas pueden ser asignadas masivamente.
    protected $fillable = [
        'fecha',  
        'id_registro_vehicular',
        'id_registro_combustible',
        'total',
        'empresa',
        'cog',
    ];

    // Se define una relación inversa: este resumen pertenece a un vehículo.
    public function vehiculo() { 
        return $this->belongsTo(RegistroVehicular::class, 'id_registro_vehicular', 'id');
    }
    
    // Se define una relación inversa: este resumen pertenece a un registro de combustible.
    public function combustible() {
        return $this->belongsTo(RegistroCombustible::class, 'id_registro_combustible','id');
    }
}

