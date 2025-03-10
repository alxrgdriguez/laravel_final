<?php

namespace App\Http\Controllers\Api;

use App\Enums\RegistrationStatus;
use App\Http\Requests\StoreEvaluationRequest;
use App\Models\Evaluation;

use App\Models\Registration;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    // Mostrar evaluaciones al admin y profesor
    public function index(Request $request)
    {
        // Sacar todos los registros que estan activos
        $query = Registration::query()->where('statusReg', RegistrationStatus::ACCEPTED);

        if (auth()->user()->isTeacher()) {
            $query->whereHas('course', fn ($q) => $q->where('teacher_id', auth()->id()));
        }

        // Filtro por nombre de estudiante
        if ($request->filled('student')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->student . '%')
                    ->orWhere('surnames', 'LIKE', '%' . $request->student . '%');
            });
        }

        // Filtro por nombre del curso
        if ($request->filled('course')) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->course . '%');
            });
        }

        $registrations = $query->paginate(10);

        return view('private.evaluations.index', compact('registrations'));
    }

    /**
     * Mostrar formulario para editar evaluación.
     */
    public function edit($id)
    {
        $registration = Registration::find($id);

        if (!$registration) {
            return redirect()->route('admin.evaluations.index')->with('error', 'La evaluación no existe.');
        }

        return view('private.evaluations.edit', compact('registration'));
    }


    /**
     * Actualizar evaluación.
     */
    public function update(Request $request, Registration $registration)
    {

        $request->validate([
            'final_note' => 'nullable|numeric|min:0|max:10',
            'comments' => 'nullable|string|max:500',
        ]);

        $evaluation = $registration->evaluation();

        if (!$evaluation) {
            $evaluation = new Evaluation();
        }

        $evaluation->final_note = $request->input('final_note');
        $evaluation->comments = $request->input('comments');
        $evaluation->save();


        // Redireccionar con mensaje de éxito
        return redirect()->route('admin.evaluations.index')
            ->with('success', 'Evaluación actualizada correctamente al usuario ' . $registration->user->name . '.');
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
    public function store(StoreEvaluationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        //
    }
}
