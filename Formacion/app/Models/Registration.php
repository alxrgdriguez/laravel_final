<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Registration extends Pivot // Es la tabla intermedia de many-to-many
{
    /** @use HasFactory<\Database\Factories\RegistrationFactory> */
    use HasFactory;

    protected $table = 'registrations';

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function evaluation(): Evaluation
    {
        return Evaluation::query()->where('course_id', $this->course_id)->where('user_id', $this->user_id)->first();
    }

    protected $casts = [
        'statusReg' => RegistrationStatus::class,
    ];


    protected $fillable = [
        'course_id',
        'user_id',
        'statusReg',
    ];
}
