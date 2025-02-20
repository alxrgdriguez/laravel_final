<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Estudiantes
        User::factory(30)->create();

        // Profesores
        User::factory(5)->teacher()->create();

        // Administradores
        User::factory(1)->admin()->create();
    }
}
