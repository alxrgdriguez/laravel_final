<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCouseMaterialRequest;
use App\Http\Requests\UpdateCouseMaterialRequest;
use App\Models\CourseMaterial;
use Illuminate\Support\Facades\Request;

class CouseMaterialController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouseMaterialRequest $request)
    {
        //
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
