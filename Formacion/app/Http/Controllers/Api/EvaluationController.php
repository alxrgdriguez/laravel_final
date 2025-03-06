<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use App\Models\Evaluation;
use http\Client\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EvaluationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    // Mostrar evaluaciones al admin y profesor
    public function index(Request $request)
    {
        $evaluations = auth()->user()->isAdmin()
            ? Evaluation::simplePaginate(10)
            : Evaluation::whereHas('course', function ($query) {
                $query->where('teacher_id', auth()->id());
            })->simplePaginate(10);

        return view('private.evaluations.index', compact('evaluations'));
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
