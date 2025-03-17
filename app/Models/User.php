<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\RegistroRol; 

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tabla a la que hace referencia
    protected $table = 'users';

    // Campos que se pueden asignar masivamente
    protected $fillable = ['name', 'password', 'role'];

    // Campos que se deben ocultar (no serán accesibles desde las respuestas)
    protected $hidden = ['password', 'remember_token'];

    // Para cifrar la contraseña
    protected $casts = [
        'password' => 'hashed',
    ];

    

    // Si deseas usar el campo 'nombre' para la autenticación
    public function getAuthIdentifierName()
    {
        return 'name'; // Cambiado de 'email' a 'name'
    }

    public function isAdmin()
    {
        return $this->role === 'Administrador';
    }

    public function isUsuario()
    {
        return $this->role === 'Usuario';
    }

    public function isVisualizador()
    {
        return $this->role === 'Visualizador';
    }

    public function create()
{
    $roles = RegistroRol::all(); // Obtiene todos los roles desde la base de datos
    return view('User.RUCreate', compact('roles')); // Pasa los roles a la vista
}

}

