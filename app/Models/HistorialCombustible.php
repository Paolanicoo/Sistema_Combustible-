<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialCombustible extends Model
{
    protected $table = 'historial_combustible'; // Opcional pero recomendado
    
    protected $fillable = [
        'combustible_id',
        'cantidad_retirada',
        'persona',
        'fecha',
        'cantidad_restante',
        'observacion'
    ];

    public function combustible()
    {
        return $this->belongsTo(Combustible::class);
    }
}
