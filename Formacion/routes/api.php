<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function () {

    // 📌 Rutas públicas (sin autenticación)
    Route::post('/login', [UserController::class, 'api_login']);
    Route::post('/register', [UserController::class, 'api_register']);

    // 📌 Rutas protegidas con Sanctum
    Route::middleware('auth:sanctum')->group(function () {

        // 📌 Rutas de Cursos
        Route::prefix('/courses')->group(function () {
            Route::get('/', [CourseController::class, 'api_index_courses']); // Listar cursos con filtros
            Route::get('/{course}', [CourseController::class, 'api_show_course']); // Ver detalles de un curso

            // Solo los administradores pueden crear y eliminar cursos
            Route::middleware('can:create,App\Models\Course')->group(function () {
                Route::post('/', [CourseController::class, 'api_create_course']); // Crear un curso
            });

            Route::middleware('can:delete,course')->group(function () {
                Route::delete('/{course}', [CourseController::class, 'api_delete_course']); // Eliminar un curso
            });
        });

        // 📌 Rutas de Estudiantes
        Route::prefix('/students')->group(function () {
            Route::get('/{dni}/registrations', [UserController::class, 'api_show_registrations']); // Ver inscripciones de un alumno
        });

        // 📌 Registration Routes
        Route::prefix('/registrations')->group(function () {
            Route::post('/', [RegistrationController::class, 'api_create_registration']); // Register a student
            Route::delete('/{registration}', [RegistrationController::class, 'api_delete_registration'])->middleware('can:delete,registration'); // Eliminar una inscripción
            Route::put('/{registration}/status', [RegistrationController::class, 'api_update_registration_status'])->middleware('can:approve,registration'); // Aprobar o rechazar una inscripcións
        });
    });
});
