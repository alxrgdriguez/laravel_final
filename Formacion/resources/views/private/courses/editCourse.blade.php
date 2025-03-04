@extends('private.components.layouts.layout')

@props(['title' => 'Editar | Curso'])

@section('content')
    <div class="flex items-center justify-center bg-gradient-to-b from-gray-100 to-gray-300 dark:from-gray-800 dark:to-gray-900 py-12">
        <div class="max-w-xl w-full bg-white dark:bg-gray-900 shadow-lg rounded-2xl p-8 border border-gray-300 dark:border-gray-700 min-h-[750px] flex flex-col justify-center">
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-10">
                📚 Editar Curso
            </h1>
            @include('private.components.CourseForm.course-form', ['course' => $course])
        </div>
    </div>
@endsection
