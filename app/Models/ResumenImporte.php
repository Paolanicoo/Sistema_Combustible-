<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumenImporte extends Model
{
    use HasFactory;
    protected $table = 'resumen_importes'; // Asegúrate de que el nombre de la tabla es correcto

    protected $fillable = [
        'fecha',  
        'id_registro_vehicular',
        'id_registro_combustible',
        'total',
        'empresa',
        'cog',
    ];

    public function vehiculo() { 
        return $this->belongsTo(RegistroVehicular::class, 'id_registro_vehicular', 'id');
    }
    
    public function combustible() {
        return $this->belongsTo(RegistroCombustible::class, 'id_registro_combustible','id');
    }
}

