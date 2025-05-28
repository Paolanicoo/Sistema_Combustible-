<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    // Declaración de una propiedad estática protegida para reutilizar la contraseña en múltiples usuarios generados.
    protected static ?string $password;

    /**
     * Define los valores por defecto para un nuevo usuario generado con la factory.
     * 
     * @return array Arreglo con los atributos simulados para crear un usuario de prueba.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(), // Genera un nombre falso aleatorio.
            'password' => static::$password ??= Hash::make('password'), // Asigna una contraseña hasheada. Si ya fue definida previamente, la reutiliza para mantener consistencia.
            'role' => $this->faker->randomElement(['Usuario', 'Visualizador']), // Asigna aleatoriamente un rol entre 'Usuario' y 'Visualizador'.
            'remember_token' => Str::random(10), 
        ];
    }

    /**
     * Crear un usuario administrador
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Admin',
            'role' => 'Administrador',
            'password' => Hash::make('holamundo1234'),
        ]);
    }
}