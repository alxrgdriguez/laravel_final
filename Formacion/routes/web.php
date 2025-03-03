<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/students', [UserController::class, 'index'])->name('student.courses.index');

    // Agrupar rutas privadas (Solo admin y profesores pueden acceder)
    Route::middleware(['auth','adminOrTeacher'])->prefix('admin')->group(function () {

        // Cursos
        Route::get('/courses', [CourseController::class, 'index'])->name('admin.courses.index');
        Route::get('/courses/create', [CourseController::class, 'create'])->name('admin.courses.create');
        Route::post('/courses/store', [CourseController::class, 'store'])->name('admin.courses.store');

        // Inscripciones
        Route::get('/registrations', [RegistrationController::class, 'index'])->name('admin.registrations.index');

        // Evaluaciones
        Route::get('/evaluations', [EvaluationController::class, 'index'])->name('admin.evaluations.index');

        // Usuarios (Solo admin)
        Route::middleware(['can:manage-users'])->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        });

    });

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
