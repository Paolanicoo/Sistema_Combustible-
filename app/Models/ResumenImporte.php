<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumenImporte extends Model
{
    use HasFactory;

    public function vehiculos() {
        return $this->hasmany(RegistroVehicular::class);
    }
    public function combustible() {
        return $this->hasmany(RegistroCombustible::class);
    }
}

