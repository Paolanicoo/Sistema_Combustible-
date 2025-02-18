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

    public function combustible() {
        return $this->belongsTo(RegistroCombustible::class);
    }

    public function importe () {
        return $this->belongsTo(ResumenImporte::class);
    }
}
