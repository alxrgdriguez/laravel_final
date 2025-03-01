<?php

namespace App\Http\Controllers\Api;

use App\Enums\CourseStatus;
use App\Enums\UserRole;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;


class CourseController extends Controller
{
    use AuthorizesRequests;
    public function api_index_courses(Request $request)
    {
        $courses = Course::query();

        if ($request->has('category_id')) {
            $courses->where('category_id', $request->category_id);
        }
        if ($request->has('status')) {
            $courses->where('status', $request->status);
        }

        return CourseResource::collection($courses->paginate(10));
    }

    public function api_show_course(Course $course)
    {
        return new CourseResource($course);
    }

    public function api_create_course(Request $request)
    {
        if ($request->user()->role !== UserRole::ADMIN) {
            return response()->json(['message' => 'Unauthorized. Only admins can create courses.'], 403);
        }

        $this->authorize('create', Course::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'teacher_id' => 'required|exists:users,id',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:' . implode(',', CourseStatus::values()),
        ]);

        $course = Course::create($validated);

        return new CourseResource($course);
    }

    public function api_delete_course(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return response()->json(['message' => 'Course deleted'], 200);
    }
}
