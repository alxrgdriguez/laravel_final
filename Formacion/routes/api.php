<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('/v1')->group(function () {

    // Rutas públicas (no requieren autenticación)
    Route::post('/login', [UserController::class, 'api_login']);
    Route::post('/register', [UserController::class, 'api_register']);

    // Rutas protegidas con Sanctum
    Route::middleware('auth:sanctum')->group(function () {

        // Rutas de Cursos
        Route::prefix('/courses')->group(function () {
            Route::get('/', [CourseController::class, 'api_index_courses']);
            Route::get('/{course}', [CourseController::class, 'api_show_course']);
            Route::post('/', [CourseController::class, 'api_create_course']);
            Route::delete('/{course}', [CourseController::class, 'api_delete_course']);
        });

        // Rutas de Estudiantes
        Route::prefix('/students')->group(function () {
            Route::get('/{dni}/registrations', [UserController::class, 'api_show_registrations']);
            Route::delete('/{dni}/registrations/{course_id}', [UserController::class, 'api_delete_registration']);
        });

        // Rutas de Inscripciones
        Route::prefix('/registrations')->group(function () {
            Route::post('/', [RegistrationController::class, 'api_create_registration']);
        });
    });
});

