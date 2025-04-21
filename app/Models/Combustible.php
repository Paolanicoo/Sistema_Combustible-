<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combustible extends Model
{
    use HasFactory;

    protected $table = 'combustible';
    
    protected $fillable = [
        'fecha',
        'cantidad_entrada',
        'cantidad_actual',
        'descripcion'
    ];
    
    public function historial()
    {
        return $this->hasMany(HistorialCombustible::class);
    }
}