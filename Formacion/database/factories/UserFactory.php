<?php

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Random\RandomException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Generar un DNI aleatorio
     * @throws RandomException
     */
    private function dniAleatorio(): string
    {
        $dniNumbers = random_int(10000000, 99999999);
        $letters = 'TRWAGMYFPDXBNJZSQVHLCKE';
        return $dniNumbers . $letters[$dniNumbers % 23];
    }


    /**
     * Definicion del usuario por defecto.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dni' => $this->dniAleatorio(),
            'name' => $this->faker->name(),
            'surnames' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone_number' => $this->faker->numerify('#########'),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'speciality' => null,
            'role' => UserRole::STUDENT,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    // Definir las propiedades de profesor y administrador
    public function teacher(): static
    {

        return $this->state(fn (array $attributes) => [

            'role' => UserRole::TEACHER,
            'speciality' => $this->faker->jobTitle,
        ]);
    }
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::ADMIN,
        ]);
    }
}
