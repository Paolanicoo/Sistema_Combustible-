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
        return $this->belongsTo(RegistroVehicular::class);
    }
    
}
