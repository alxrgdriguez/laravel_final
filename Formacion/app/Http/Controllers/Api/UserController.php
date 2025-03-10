<?php

namespace App\Http\Controllers\Api;

use App\Enums\CourseStatus;
use App\Enums\UserRole;
use App\Http\Resources\RegistrationResource;
use App\Models\Category;
use App\Models\Course;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function api_register(Request $request)
    {
        // Si el usuario ya existe, devolver un error
        if (User::where('email', $request->email)->first()) {
            return response()->json(['message' => 'User already exists'], 409);
        }

        $request->validate([
            'dni' => 'required|string|unique:users,dni',
            'name' => 'required|string',
            'surnames' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'role' => 'required|in:student,teacher,admin',
        ]);

        $user = User::create([
            'dni' => $request->dni,
            'name' => $request->name,
            'surnames' => $request->surnames,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'city' => $request->city,
            'role' => $request->role,
        ]);

        // Generar un token al registrarse
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function api_login(Request $request)
    {
        // SI el usuario no existe, devolver un error
        if (!User::where('email', $request->email)->first()) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Verifica si el usuario existe
        $user = User::where('email', $request->email)->first();
        if (!$user || !Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        // Generar un nuevo token
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function api_logout(Request $request)
    {
        $request->user()->tokens()->delete(); // 🔹 Elimina TODOS los tokens del usuario
        return response()->json(['message' => 'Logged out'], 200);
    }


    public function api_show_registrations($dni)
    {
        $user = User::where('dni', $dni)->firstOrFail();
        $registrations = $user->registrations;
        return RegistrationResource::collection($registrations);
    }

    //////////////////////////////////////////////////////////////////////////

    // WEB
    public function index(Request $request)
    {
        if ($request->user()->role === UserRole::STUDENT) {
            return redirect()->route('student.courses.index');
        }

        return redirect()->route('admin.courses.index');
    }

    // Pagina principal de nosotros
    public function index_nosotros()
    {
        return view('public.nosotros.nosotros');
    }

    // Página principal de los estudiantes
    public function index_students()
    {
        // Obtener cursos activos y paginar de 9 en 9
        $courses = Course::where('status', CourseStatus::ACTIVE)->simplePaginate(9);
        $categories = Category::all();

        // Retornar la vista correcta
        return view('public.courses.index', compact('courses', 'categories'));
    }


    // Buscar cursos filtros
    public function search_students(Request $request)
    {
        $query = Course::query();

        // Filtrar por nombre del curso si se proporciona un término de búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filtrar por categoría si se proporciona una categoría
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Paginar los resultados de 9 en 9 usando simplePaginate
        $courses = $query->with('category', 'teacher')->simplePaginate(9);
        $categories = Category::all(); // Obtener todas las categorías para el filtro

        return view('public.courses.index', compact('courses', 'categories'));
    }


    // Inscribirse al curso
    public function student_registrate($courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        // Verificar si el usuario ya está inscrito
        $registration = Registration::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($registration) {
            // Si ya está inscrito, cancelar inscripción
            $registration->delete();
            return back()->with('error', 'Has cancelado tu inscripción en el curso ' . $course->name);
        } else {
            // Si no está inscrito, inscribirse
            Registration::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);
            return back()->with('success', 'Te has inscrito correctamente en el curso '. $course->name);
        }
    }

    public function my_courses()
    {
        $user = Auth::user();
        $courses = $user->studentCourses;
        return view('public.courses.my-courses', compact('courses'));
    }

    public function index_admin_users(Request $request)
    {
        $query = User::query();

        // Filtro por nombre
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Filtro por rol
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Usamos simplePaginate() para la paginación simple
        $users = $query->simplePaginate(10)->appends($request->query());

        return view('private.users.index', compact('users'));

    }

    public function index_admin_update(Request $request, User $user)
    {

        if ($user->isAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'No puedes cambiar el rol de un administrador.');
        }

        $request->validate([
            'role' => 'required|in:admin,teacher,student',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.users.index')->with('success', 'Rol del usuario actualizado correctamente.');
    }

    public function index_admin_delete(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'No puedes eliminar a un administrador.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');

    }
}
