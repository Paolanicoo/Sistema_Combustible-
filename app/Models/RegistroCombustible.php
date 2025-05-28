<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCombustible extends Model
{
    // Se incluye el trait HasFactory para permitir la creación de registros con factories (útil en los seeders).
    use HasFactory;
    
    // Se especifica el nombre de la tabla en la base de datos asociada a este modelo.
    protected $table = 'registro_combustibles';
    
    // Se define qué columnas pueden ser asignadas masivamente.
    protected $fillable = [
        'fecha', 
        'precio',
        'tipo',
        'entradas',
        'salidas',
        'num_factura', 
        'observacion',
        'id_registro_vehicular',
    ];

    // Se define una relación inversa: este registro de combustible pertenece a un vehículo.
    public function vehiculos() {
        return $this->belongsTo(RegistroVehicular::class, 'id_registro_vehicular'); // Reemplaza 'vehiculo_id' por el nombre real de la clave foránea.
    }

    
}
