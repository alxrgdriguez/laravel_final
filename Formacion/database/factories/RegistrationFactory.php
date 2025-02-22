<?php

namespace Database\Factories;

use App\Enums\StatusRegistration;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'statusReg' => fake()->randomElement(StatusRegistration::values()),
        ];
    }
}
