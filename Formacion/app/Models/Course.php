<?php

namespace App\Models;

use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'teacher_id',
        'duration',
        'status',
    ];

    protected $casts = [
        'status' => CourseStatus::class,
    ];

    /**
     * Relación con la categoría (un curso pertenece a una categoría).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relación con el profesor (un curso pertenece a un profesor).
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id'); // 'teacher_id' es la clave foránea
    }

    /**
     * Relación con las inscripciones (un curso tiene muchas inscripciones).
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Relación con las evaluaciones (un curso tiene muchas evaluaciones).
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }
}
