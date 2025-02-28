<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Relación: Un profesor tiene muchos cursos.
     */
    public function teacherCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    /**
     * Relación: Un estudiante está inscrito en muchos cursos.
     */
    public function studentCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'registrations', 'student_id', 'course_id');
    }

    /**
     * Relación: Un estudiante tiene muchas inscripciones.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'student_id');
    }

    /**
     * Relación: Un estudiante tiene muchas evaluaciones.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'student_id');
    }

    /**
     * Atributos permitidos para asignación masiva.
     */
    protected $fillable = [
        'dni',
        'name',
        'surnames',
        'email',
        'password',
        'phone_number',
        'address',
        'city',
        'role',
    ];

    /**
     * Atributos ocultos en respuestas JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting de atributos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }
}
