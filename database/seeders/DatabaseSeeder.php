<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RegistroRol;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar datos existentes
        User::query()->delete();
        RegistroRol::query()->delete();

        // Crear roles
        RegistroRol::insert([
            ['rol' => 'Administrador', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['rol' => 'Usuario', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['rol' => 'Visualizador', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Crear usuario administrador
        User::factory()->create([
            'name' => 'Admin',
            'password' => Hash::make('holamundo1234'),
            'role' => 'Administrador'
        ]);

    }
}
