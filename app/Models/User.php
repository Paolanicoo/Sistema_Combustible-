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

    // Tabla a la que hace referencia.
    protected $table = 'users';

    // Campos que se pueden asignar masivamente.
    protected $fillable = [
        'name',
        'password',
        'role',
        'is_protected',
    ];

    // Campos que se deben ocultar.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting de campos.
    protected $casts = [
        'password' => 'hashed',
        'is_protected' => 'boolean',
    ];

    // Si deseas usar el campo 'nombre' para la autenticación.
    public function getAuthIdentifierName()
    {
        return 'name';
    }

    // Verifica si el usuario tiene el rol de 'Administrador'.
    public function isAdmin()
    {
        return $this->role === 'Administrador';
    }

    // Verifica si el usuario tiene el rol de 'Usuario'.
    public function isUsuario()
    {
        return $this->role === 'Usuario';
    }

    // Verifica si el usuario tiene el rol de 'Visualizador'.
    public function isVisualizador()
    {
        return $this->role === 'Visualizador';
    }
    
    // Verifica si el usuario está protegido contra modificaciones.
    public function isProtected()
    {
        return $this->is_protected === true;
    }

    // Muestra el formulario para crear un nuevo usuario.
    public function showCreateForm()
    {
        $roles = RegistroRol::all(); // Obtiene todos los roles desde la base de datos.
        return view('User.RUCreate', compact('roles')); // Pasa los roles a la vista.
    }
}

