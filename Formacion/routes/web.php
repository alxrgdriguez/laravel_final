<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseMaterialController;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\CourseMaterial;
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
        Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('admin.courses.delete');
        Route::patch('/courses/{course}/finalize', [CourseController::class, 'finalize'])->name('admin.courses.finalize');
        Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('admin.courses.edit');
        Route::patch('/courses/{course}', [CourseController::class, 'update'])->name('admin.courses.update');

        // Solo el profesor puede añadir materiales a sus propios cursos
        Route::get('{course}/materials/add', [CourseMaterialController::class, 'create'])->name('admin.courses.materials.create');
        Route::post('{course}/materials/store', [CourseMaterialController::class, 'store'])->name('admin.courses.materials.store');

        // Inscripciones
        Route::get('/registrations', [RegistrationController::class, 'index'])->name('admin.registrations.index');
        Route::patch('/registrations/{registration}/accept', [RegistrationController::class, 'accept'])->name('admin.registrations.accept');
        Route::patch('/registrations/{registration}/cancelled', [RegistrationController::class, 'cancel'])->name('admin.registrations.cancelled');

        // Evaluaciones
        Route::get('/evaluations', [EvaluationController::class, 'index'])->name('admin.evaluations.index');
        Route::get('/evaluations/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('admin.evaluations.edit');
        Route::patch('/evaluations/{evaluation}', [EvaluationController::class, 'update'])->name('admin.evaluations.update');

        // Usuarios (Solo admin)
        Route::middleware(['onlyAdmin'])->group(function () {
            Route::get('/users', [UserController::class, 'index_admin_users'])->name('admin.users.index');
            Route::patch('/users/{user}', [UserController::class, 'index_admin_update'])->name('admin.users.update');
            Route::delete('/users/{user}', [UserController::class, 'index_admin_delete'])->name('admin.users.delete');
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
