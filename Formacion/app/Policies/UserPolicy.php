<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user)
    {
        // Solo los administradores pueden ver todos los usuarios
        return $user->role === 'admin';
    }

    public function view(User $user, User $model)
    {
        // Los usuarios solo pueden ver su propio perfil
        return $user->id === $model->id || $user->role === 'admin';
    }

    public function create(User $user)
    {
        // Solo los administradores pueden crear usuarios
        return $user->role === 'admin';
    }

    public function delete(User $user, User $model)
    {
        // Solo los administradores pueden eliminar usuarios
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
