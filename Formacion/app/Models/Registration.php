<?php

namespace App\Models;

use App\Enums\StatusRegistration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        return $this->belongsTo(User::class);
    }

    public function casts(): array
    {
        return [
            'statusReg' => StatusRegistration::class,
        ];
    }


    protected $fillable = [
        'course_id',
        'user_id',
        'statusReg',
    ];
}
