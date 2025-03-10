<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreCouseMaterialRequest;
use App\Http\Requests\UpdateCouseMaterialRequest;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;

class CourseMaterialController extends Controller
{

    // METHODS API


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
    public function create(Course $course)
    {
        return view('private.courses.material.addMaterial', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // Guardar material en el Storage de Laravel
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,mp4,txt,zip|max:20480', // 20MB Máx.
            'type' => 'required|in:pdf,video,url,repository',
        ]);

        $file = $request->file('file');

        if (!$file) {
            return back()->with('error', 'No se pudo subir el archivo.');
        }

        $path = $file->store('materials/'. $course->name);

        // Guardar en la base de datos
        CourseMaterial::create([
            'course_id' => $course->id,
            'type' => $request->type,
            'url' => $path,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Material subido correctamente al curso ' . $course->name);
    }



    /**
     * Display the specified resource.
     */
    public function show(CourseMaterial $couseMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseMaterial $couseMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouseMaterialRequest $request, CourseMaterial $couseMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseMaterial $couseMaterial)
    {
        //
    }
}
