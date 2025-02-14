<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroVehicular extends Model
{
    
    use HasFactory;
    public function combustible() {
        return $this->belongsTo(RegistroCombustible::class);
    }

    public function importe () {
        return $this->belongsTo(ResumenImporte::class);
    }
}
