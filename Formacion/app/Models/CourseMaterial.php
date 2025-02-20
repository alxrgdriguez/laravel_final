<?php

namespace App\Models;

use App\Enums\MaterialType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseMaterial extends Model
{
    /** @use HasFactory<\Database\Factories\CourseMaterialFactory> */
    use HasFactory;

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    protected $casts = [
        'type' => MaterialType::class,
    ];

    protected $fillable = [
        'course_id',
        'type',
        'url',
    ];
}
