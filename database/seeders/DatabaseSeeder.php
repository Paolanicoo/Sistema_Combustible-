<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
           'name' => 'Usuario',
            'email' => 'test@example.com',
            'pass' => bcrypt('holamundo1234')
        ]);
    }
}
