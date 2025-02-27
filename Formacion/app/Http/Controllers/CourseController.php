<?php

namespace App\Http\Controllers;

use App\Enums\CourseStatus;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Request;

class CourseController extends Controller
{
    use AuthorizesRequests;

    // METHODS API
    public function api_index_courses(Request $request)
    {
        $courses = Course::filter($request->all())->paginate(10);
        return CourseResource::collection($courses);
    }

    public function api_show_course(Course $course)
    {
        return new CourseResource($course);
    }

    public function api_create_course(Request $request)
    {
        $this->authorize('create', Course::class);

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'teacher_id' => 'required|exists:users,id',
            'duration' => 'required|integer',
            'status' => 'required|in:active,finished,cancelled',
        ]);

        $course = Course::create($request->all());
        return new CourseResource($course);
    }

    public function api_delete_course(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();
        return response()->json(null, 204);
    }

    // METHODS WEB
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
