<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RegistroRol;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear un usuario de prueba con factory
        User::factory(1)->create();

        // Crear un usuario manualmente con nombre y contraseña específica
        User::factory()->create([
            'name' => 'Admin',
            'password' => bcrypt('holamundo1234'),
            'role' => 'Administrador', // Asignamos un rol directamente
        ]);

        // Insertar roles en la tabla registro_rols
        RegistroRol::insert([
            ['rol' => 'Administrador', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['rol' => 'Usuario', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['rol' => 'Visualizador', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
