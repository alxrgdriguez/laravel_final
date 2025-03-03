<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RegistrationPolicy
{
    use AuthorizesRequests;

    public function viewAny(User $user)
    {
        // Solo los administradores pueden ver todas las inscripciones
        return $user->role === UserRole::ADMIN;
    }

    public function view(User $user, Registration $registration)
    {
        // Los administradores pueden ver cualquier inscripción
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        // Los profesores solo puede ver inscripciones de sus propios cursos
        if ($user->role === UserRole::TEACHER && $registration->course->teacher_id === $user->id) {
            return true;
        }

        // Un estudiante solo puede ver sus propias inscripciones
        if ($user->role === UserRole::STUDENT && $registration->user_id === $user->id) {
            return true;
        }

        // Si no cumple ninguno de los casos anteriores, no se puede ver la inscripción
        return false;
    }

    public function create(User $user, Course $course)
    {
        /// Un administrador puede inscribir a cualquier estudiante
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        // Un profesor NO puede inscribirse es cursos
        if ($user->role === UserRole::TEACHER) {
            return false;
        }

        // Un estudiante solo puede inscribirse si no está ya inscrito es el curso
        return $user->role === UserRole::STUDENT &&
            !$course->registrations()->where('student_id', $user->id)->exists();
    }

    public function delete(User $user, Registration $registration)
    {
        // Los administradores pueden eliminar cualquier inscripción
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        // Un estudiante solo puede cancelar SU PROPIA inscripción
        if ($user->role === UserRole::STUDENT && $registration->user_id === $user->id) {
            return true;
        }

        // Si no cumple ninguno de los casos anteriores, no se puede eliminar la inscripción
        return false;
    }

    public function approve(User $user, Registration $registration)
    {
        return $user->role === UserRole::ADMIN || $user->id === $registration->course->teacher_id;
    }

}
