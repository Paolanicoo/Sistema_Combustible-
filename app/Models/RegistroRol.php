<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroRol extends Model
{
    use HasFactory;

    // Nombre de la tabla si no sigue la convención de Laravel
    protected $table = 'registro_rols'; 

    // Campos que se pueden llenar masivamente
    protected $fillable = ['rol', 'estado'];

    // Campos que se deben ocultar en las conversiones a array/JSON
    protected $hidden = [];

    // Cast de tipos de datos
    protected $casts = [
        'estado' => 'boolean', // Asegura que 'estado' sea tratado como booleano
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public static function rules()
    {
        return [
            'rol' => 'required|string|max:25|unique:registro_rols,rol',
            'estado' => 'boolean'
        ];
    }
}