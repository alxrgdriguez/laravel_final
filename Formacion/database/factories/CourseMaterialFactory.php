<?php

namespace Database\Factories;

use App\Enums\MaterialType;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseMaterial>
 */
class CourseMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = CourseMaterial::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generar un nombre de archivo simulado
        $originalName = $this->faker->word() . '.pdf';
        $encryptedName = md5(time() . $originalName) . '.pdf';

        // Crear un archivo falso en storage para pruebas
        $filePath = 'materials/' . $encryptedName;
        Storage::disk('local')->put($filePath, 'Contenido de prueba del archivo.');

        return [
            'course_id' => Course::inRandomOrder()->first()->id, // Tomar un curso aleatorio
            'type' => $this->faker->randomElement(MaterialType::values()), // Tipo aleatorio
            'url' => $this->faker->url, // URL aleatoria
        ];
    }
}
