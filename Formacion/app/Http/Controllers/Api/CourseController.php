<?php

namespace App\Http\Controllers\Api;

use App\Enums\CourseStatus;
use App\Enums\UserRole;
use App\Http\Resources\CourseResource;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


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

    // Inicio de la vista de cursos
    public function index()
    {
        $user = Auth::user();

        if ($user->role === UserRole::ADMIN) {
            $courses = Course::with('teacher')->simplePaginate(10);
        } else {
            $courses = Course::with('teacher')->where('teacher_id', $user->id)->paginate(10);
        }

        return view('private.courses.index', compact('courses'));

    }


    // Llamar a la vista de crear curso
    public function create(Request $request){

        $categories = Category::all();
        $users = User::where('role', UserRole::TEACHER)->get();
        return view('private.courses.createCourse', compact('categories', 'users'));
    }

    // Guardar nuevo curso
    public function store(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'teacher_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', UserRole::TEACHER) // Solo users con rol "teacher"
            ],
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:active,cancelled,finalized',
        ]);

        // Crear el curso
        Course::create($request->all());

        // Obtener los cursos actualizados y pasarlos a la vista
        $courses = Course::with(['teacher', 'category'])->simplePaginate(10);
        return redirect()->route('admin.courses.index')->with('success', 'Curso creado exitosamente.');

    }


}
