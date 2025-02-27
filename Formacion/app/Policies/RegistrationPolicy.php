<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RegistrationPolicy
{
    use AuthorizesRequests;

    public function viewAny(User $user)
    {
        // Solo los administradores y profesores pueden ver todas las inscripciones
        return in_array($user->role, ['admin', 'teacher']);
    }

    public function view(User $user, Registration $registration)
    {
        // Los alumnos solo pueden ver sus propias inscripciones
        return $user->id === $registration->user_id || in_array($user->role, ['admin', 'teacher']);
    }

    public function create(User $user)
    {
        // Solo los alumnos pueden crear inscripciones
        return $user->role === 'student';
    }

    public function delete(User $user, Registration $registration)
    {
        // Solo los administradores pueden eliminar inscripciones
        return $user->role === 'admin';
    }
}
