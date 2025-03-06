<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroRol extends Model
{
    use HasFactory;
    protected $fillable = ['rol', 'estado'];
}
