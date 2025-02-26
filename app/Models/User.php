<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
   


    use HasFactory;
    protected $table = 'users';

    protected $fillable = ['nombre', 'password'];

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
    ];
    


    public function isAdmin()
{
    return $this->role === 'admin';
}

public function isUsuario()
{
    return $this->role === 'usuario';
}

public function isVisualizador()
{
    return $this->role === 'visualizador';
}

}
