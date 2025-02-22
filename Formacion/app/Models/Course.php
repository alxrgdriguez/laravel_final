<?php

namespace App\Models;

use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function registration(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function evaluation(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    protected $casts = [
        'status' => CourseStatus::class,
    ];

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'teacher_id',
        'duration',
        'status',
    ];


}
