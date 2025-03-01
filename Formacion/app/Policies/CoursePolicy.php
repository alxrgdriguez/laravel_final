<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    public function viewAny(User $user)
    {
        // Todos los usuarios pueden ver los cursos
        return true;
    }

    public function view(User $user, Course $course)
    {
        // Todos los usuarios pueden ver un curso específico
        return true;
    }

    public function create(User $user)
    {
        // Solo los administradores pueden crear cursos
        return $user->role === UserRole::ADMIN;
    }

    public function update(User $user, Course $course)
    {
        // Solo los administradores pueden actualizar cursos
        return $user->role === UserRole::ADMIN;
    }

    public function delete(User $user, Course $course)
    {
        // Solo los administradores pueden eliminar cursos
        return $user->role === UserRole::ADMIN;
    }
}
