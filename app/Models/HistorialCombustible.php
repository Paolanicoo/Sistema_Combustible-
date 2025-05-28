<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialCombustible extends Model
{
    // Se especifica el nombre de la tabla en la base de datos asociada a este modelo.
    protected $table = 'historial_combustible'; 
    
    // Se define qué columnas pueden ser asignadas masivamente.
    protected $fillable = [
        'combustible_id',
        'cantidad_retirada',
        'persona',
        'fecha',
        'cantidad_restante',
        'observacion'
    ];

    // Se define una relación inversa: este historial pertenece a un registro de combustible.
    public function combustible()
    {
        return $this->belongsTo(Combustible::class);
    }
}
