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


        // Crear un administrador protegido que no podrá ser editado ni eliminado
        User::create([
            'name' => 'admin',
            'password' => Hash::make('administrador'),
            'role' => 'Administrador',
            'is_protected' => true
        ]);

        $this->command->info('Usuario administrador protegido creado exitosamente.');

    }
}
