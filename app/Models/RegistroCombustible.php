<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCombustible extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'fecha', 
        'precio',
        'entradas',
        'salidas',
    ];

    public function vehiculos() {
        return $this->belongsTo(RegistroVehicular::class, 'id_registro_vehicular'); // Reemplaza 'vehiculo_id' por el nombre real de la clave foránea
    }

    
}
