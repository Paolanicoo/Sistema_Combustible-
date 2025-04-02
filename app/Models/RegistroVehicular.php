<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroVehicular extends Model
{
    
    use HasFactory;
    
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

    public function combsutible() {
        return $this->hasMany(RegistroCombustible::class,'id_registro_combustible', 'id');
    }

    public function importes() {
        return $this->hasMany(ResumenImporte::class, 'id_registro_vehicular', 'id');
    }
    // Asegúrate de tener las relaciones bien definidas en el modelo RegistroVehicular
    public function vehiculo() {
        return $this->belongsTo(ResumenImporte::class, 'id_registro_vehicular', 'id');
    }

}
