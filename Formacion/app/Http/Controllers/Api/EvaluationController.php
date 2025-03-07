<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreEvaluationRequest;
use App\Models\Evaluation;

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
        $query = Evaluation::query()
            ->with(['user', 'course']);

        // Si el usuario es profesor, filtrar por cursos del profesor
        if (Auth::user()->isTeacher()) {
            $query->whereHas('course', function ($q) {
                $q->where('teacher_id', Auth::id());
            });
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

        $evaluations = $query->paginate(10);

        return view('private.evaluations.index', compact('evaluations'));
    }

    /**
     * Mostrar formulario para editar evaluación.
     */
    public function edit(Evaluation $evaluation)
    {
        if (auth()->user()->isTeacher() && auth()->id() !== $evaluation->course->teacher_id) {
            return redirect()->route('admin.evaluations.index')->with('error', 'No autorizado.');
        }

        return view('private.evaluations.edit', compact('evaluation'));
    }


    /**
     * Actualizar evaluación.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        // Validar datos recibidos
        $validated = $request->validate([
            'final_note' => 'nullable|numeric|min:0|max:10',
            'comments' => 'nullable|string|max:500',
        ]);

        // Actualizar la evaluación
        $evaluation->update([
            'final_note' => $validated['final_note'],
            'comments' => $validated['comments'],
        ]);

        // Redireccionar con mensaje de éxito
        return redirect()->route('admin.evaluations.index')
            ->with('success', 'Evaluación actualizada correctamente al usuario ' . $evaluation->user->name . '.');
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
