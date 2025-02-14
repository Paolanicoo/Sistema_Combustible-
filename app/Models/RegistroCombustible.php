<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCombustible extends Model
{
    use HasFactory;
    protected $table = 'registro_combustibles';
    
    protected $fillable = [
        'fecha',
        'num_factura',
        'id_registro_vehicular',
        'entradas',
        'salidas'
    ];

    public function vehiculos() {
        return $this->belongsTo(RegistroVehicular::class);
    }
    
}
