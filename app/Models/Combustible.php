<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combustible extends Model
{
    // Se incluye el trait HasFactory para permitir la creación de registros con factories (útil en los seeders).
    use HasFactory;

    // Se especifica el nombre de la tabla en la base de datos asociada a este modelo.
    protected $table = 'combustible';
    
    // Se define qué columnas pueden ser asignadas masivamente (por ejemplo, al crear o actualizar registros con create o update).
    protected $fillable = [
        'fecha',
        'cantidad_entrada',
        'cantidad_actual',
        'descripcion'
    ];
    
    // Se define una relación uno a muchos: un registro de combustible puede tener muchos registros en el historial.
    public function historial()
    {
        return $this->hasMany(HistorialCombustible::class);
    }
}