<?php

use App\Enums\CourseStatus;
use App\Enums\RegistrationStatus;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Course::class, 'course_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'user_id')->constrained()->cascadeOnDelete();
            $table->unique(['course_id', 'user_id']);
            $table->enum('statusReg', RegistrationStatus::values());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
