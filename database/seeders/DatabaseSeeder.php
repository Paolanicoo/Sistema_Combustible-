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
        // Limpia datos existentes en las tablas users y registro_rols para evitar duplicados.
        User::query()->delete();
        RegistroRol::query()->delete();

        // Crea roles básicos en la tabla registro_rols con estado activo y marcas de tiempo actuales.
        RegistroRol::insert([
            ['rol' => 'Administrador', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['rol' => 'Usuario', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['rol' => 'Visualizador', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);


        // Crear un usuario administrador protegido que no podrá ser editado ni eliminado.
        User::create([
            'name' => 'admin',
            'password' => Hash::make('administrador'),
            'role' => 'Administrador',
            'is_protected' => true
        ]);

        // Muestra mensaje en consola indicando que el usuario administrador protegido fue creado con éxito.
        $this->command->info('Usuario administrador protegido creado exitosamente.');

    }
}
