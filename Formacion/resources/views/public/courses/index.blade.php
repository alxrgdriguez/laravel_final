@extends('public.components.layouts.app')

@section('content')
    <div class="flex flex-col min-h-screen">
        <div class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <header class="mb-12 text-center">
                <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-700 dark:from-purple-400 dark:to-indigo-300">
                    Cursos de Formación Profesional
                </h1>
                <p class="mt-4 text-xl text-gray-700 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Explora y regístrate en los cursos disponibles para potenciar tu conocimiento.
                </p>
            </header>

            @if(session('success'))
                <div class="mb-6 px-6 py-4 rounded-lg bg-green-100 text-green-800 shadow-md text-lg flex items-center">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 px-6 py-4 rounded-lg bg-red-100 text-red-800 shadow-md text-lg flex items-center">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <!-- Búsqueda y Filtros -->
            <form action="{{ route('students.courses.search') }}" method="GET" class="mb-10 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex flex-grow gap-4 items-center">
                    <select name="category" class="p-3 border border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:text-white w-1/3">
                        <option value="">📌 Todas las categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <input type="text" name="search" placeholder="🔍 Buscar cursos" class="flex-grow p-3 border border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:text-white">

                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition shadow-md">
                        Buscar
                    </button>
                </div>
            </form>

            <!-- Lista de Cursos -->
            @if($courses->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach($courses as $course)
                        @php
                            $registration = auth()->user()->registrations->where('course_id', $course->id)->first();
                        @endphp
                        @if(!$registration || $registration->statusReg != \App\Enums\RegistrationStatus::ACCEPTED)
                            <x-course-card :course="$course" :registration="$registration" :showCancel="true" />
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-center py-10 text-gray-500">No hay cursos disponibles en este momento.</p>
            @endif
        </div>
    </div>
@endsection
