<?php

namespace App\Http\Controllers\Api;


use App\Enums\RegistrationStatus;
use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\UpdateRegistrationRequest;
use App\Mail\RegistrationStatusMail;
use App\Models\Evaluation;
use App\Models\Registration;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        $query = Registration::query();
        $user = auth()->user();

        // Si es profesor, solo ve inscripciones de sus cursos
        if ($user->isTeacher()) {
            $query->whereHas('course', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            });
        }

        // Filtro por estado (si no se selecciona, por defecto "pending" para profesores)
        $status = $request->input('status', ($user->isTeacher() ? null : 'pending'));
        if ($status) {
            $query->where('statusReg', $status);
        }

        // Filtro por nombre y apellios del usuario
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('surnames', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Filtro por curso
        if ($request->filled('course')) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->course . '%');
            });
        }

        // Paginación con filtros aplicados
        $registrations = $query->paginate(10);

        return view('private.registrations.index', compact('registrations', 'status'));
    }


    public function accept($id)
    {
        $registration = Registration::findOrFail($id);

        // Cambiar estado a "accepted"
        $registration->update(['statusReg' => 'accepted']);

        // Verificar si la evaluación ya existe
        $existingEvaluation = Evaluation::where('course_id', $registration->course_id)
            ->where('user_id', $registration->user_id)
            ->first();

        if (!$existingEvaluation) {
            try {
                // Crear evaluación
                $evaluation = Evaluation::create([
                    'course_id' => $registration->course_id,
                    'user_id' => $registration->user_id,
                    'final_note' => null,
                    'comments' => 'Pendiente de evaluación',
                ]);

                if (!$evaluation) {
                    throw new \Exception("No se pudo crear la evaluación en la base de datos.");
                }

            } catch (\Exception $e) {
                Log::error("Error al crear la evaluación: " . $e->getMessage());
                return redirect()->route('admin.registrations.index')->with('error', 'Error al crear la evaluación: ' . $e->getMessage());
            }
        }

        // Enviar email
        Mail::to($registration->user->email)->send(new RegistrationStatusMail($registration));

        return redirect()->route('admin.registrations.index')->with('success', 'Inscripción aceptada y evaluación creada.');
    }

    public function cancel($id)
    {
        $registration = Registration::findOrFail($id);
        $registration->update(['statusReg' => 'cancelled']);

        // Enviar email
        Mail::to($registration->user->email)->send(new RegistrationStatusMail($registration));

        return redirect()->route('admin.registrations.index')->with('error', 'Inscripción rechazada y notificación enviada.');
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
