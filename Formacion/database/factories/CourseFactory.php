<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'category_id' => Category::all()->random()->id,
            'teacher_id' => User::where('role', 'teacher')->first()->id,
            'duration' => $this->faker->numberBetween(10, 10000),
            'status' => Status::ACTIVE,
        ];
    }
}
