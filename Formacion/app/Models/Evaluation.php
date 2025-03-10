<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Evaluation extends Pivot
{
    /** @use HasFactory<\Database\Factories\EvaluationFactory> */
    use HasFactory;

    protected $table = 'evaluations';

    function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }


}
