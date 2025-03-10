<?php

namespace App\Models;

use App\Enums\CourseStatus;
use App\Enums\RegistrationStatus;
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
     * Relación: Un estudiante está inscrito es muchos cursos.
     */
    public function studentCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'registrations', 'user_id', 'course_id');
    }

    /**
     * Relación: Un estudiante tiene muchas inscripciones.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'user_id');
    }

    /**
     * Relación: Un estudiante tiene muchas evaluaciones.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'user_id');
    }

    public function isAdmin() {
        return $this->role === UserRole::ADMIN;
    }

    public function isTeacher() {
        return $this->role === UserRole::TEACHER;
    }

    public function isStudent() {
        return $this->role === UserRole::STUDENT;
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function getActiveCoursesByStudent()
    {
        return $this->studentCourses()->where('status', CourseStatus::ACTIVE)
            ->whereHas('registrations', function ($q) {
                $q->where('statusReg', RegistrationStatus::ACCEPTED);
            });

    }

    // Sacar cursos activos de un profesor
    public function getActiveCoursesByTeacher()
    {
        return $this->courses()->where('status', CourseStatus::ACTIVE);

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
     * Atributos ocultos es respuestas JSON.
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
