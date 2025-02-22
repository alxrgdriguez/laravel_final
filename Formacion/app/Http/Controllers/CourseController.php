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

    // Obtener cursos con filtros opcionales
    public function api_index(Request $request)
    {
        $courses = Course::filter($request->only(['category', 'status']))->paginate($request->input('perPage', 10));
        return CourseResource::collection($courses);
    }

    // Mostrar información de un curso
    public function api_show(Course $course)
    {
        return new CourseResource($course);
    }

    /**
     * @throws AuthorizationException
     */
    // Crear un nuevo curso (solo administradores)
    public function api_create(Request $request)
    {
        $this->authorize('create', Course::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'teacher_id' => 'required|exists:users,id',
            'duration' => 'nullable|integer',
            'status' => 'required|in:' . implode(',', CourseStatus::cases()),
        ]);

        $course = Course::create($validated);
        return response()->json(['message' => 'Course successfully registered', 'course' => new CourseResource($course)], 201);
    }

    /**
     * @throws AuthorizationException
     */
    // Eliminar un curso (solo administradores)
    public function api_delete(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();
        return response()->json(['message' => 'Course successfully removed']);
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
