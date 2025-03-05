<?php

namespace App\Http\Controllers\Api;


use App\Enums\RegistrationStatus;
use App\Models\Registration;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Inscribir a un estudiante es un curso.
     */
    public function api_create_registration(Request $request)
    {
        $course = Course::findOrFail($request->course_id);

        $this->authorize('create', [Registration::class, $course]);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:users,id',
        ]);

        // Create registration with "pending" status
        $registration = Registration::create([
            'course_id' => $validated['course_id'],
            'student_id' => $validated['student_id'],
            'status' => 'pending',
        ]);

        return response()->json($registration, 201);
    }

    /**
     * Show all registrations of a student.
     */
    public function api_show_registrations($dni)
    {
        $user = User::where('dni', $dni)->firstOrFail();

        $this->authorize('viewAny', Registration::class);

        return response()->json($user->registrations);
    }

    public function api_delete_registration(Registration $registration)
    {
        // Manejo de error: si la inscripción no existe
        if (!$registration) {
            return response()->json(['message' => 'Registration not found'], 404);
        }

        $this->authorize('delete', $registration);

        // Eliminar la inscripción
        $registration->delete();

        // Devolver mensaje de éxito
        return response()->json(['message' => 'Registration deleted successfully'], 200);
    }

    /**
     * Approve or reject a registration (Only Admins & Teachers can approve).
     */
   public function api_update_registration_status(Request $request, Registration $registration)
    {
        $this->authorize('approve', $registration);

        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);

        $registration->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Registration updated', 'registration' => $registration]);
    }

// ROUTES WEB

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Si es admin, ve todas las inscripciones "PENDING"
        if ($user->isAdmin()) {
            $registrations = Registration::where('statusReg', RegistrationStatus::PENDING->value)->simplePaginate(10);
        }
        // Si es profesor, solo ve las inscripciones de sus cursos
        else {
            $registrations = Registration::whereHas('course', function ($query) use ($user) {
                $query->where('teacher_id', $user->id);
            })->where('status', RegistrationStatus::PENDING->value)->paginate(10);
        }

        return view('private.registrations.index', compact('registrations'));
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
    public function store(StoreRegistrationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Registration $registration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registration $registration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegistrationRequest $request, Registration $registration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registration $registration)
    {
        //
    }

}
