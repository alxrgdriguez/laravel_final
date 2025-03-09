@extends('public.components.layouts.app')

@section('content')
    <div class="flex flex-col min-h-screen">
        <div class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <header class="mb-12 text-center">
                <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-700 dark:from-purple-400 dark:to-indigo-300">
                    <a href="{{ route('index') }}" class="flex justify-center items-center text-white h-50 w-auto font-bold text-2xl hover:text-yellow-400 transition">
                        <img src="{{ asset('imgs/login-img.png') }}" alt="Cursos Online" class="h-40 w-auto mb-6 rounded-lg shadow-lg">
                    </a>
                    Plataforma de Formación Profesional
                </h1>
                <p class="mt-4 text-xl text-gray-700 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Explora cursos excepcionales que impulsarán tu carrera profesional con expertos en la industria.
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
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out relative border border-gray-200 dark:border-gray-700">
                                <div class="absolute top-4 right-4 bg-indigo-600 text-white px-3 py-1 rounded-lg text-sm font-semibold shadow-md">
                                    {{ $course->category->name ?? 'No categorizado' }}
                                </div>
                                <div class="h-48 flex items-center justify-center bg-gradient-to-r from-indigo-500 to-purple-700">
                                    <span class="text-5xl text-white">📚</span>
                                </div>
                                <div class="p-6">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $course->name }}</h2>
                                    <p class="mt-3 text-gray-600 dark:text-gray-400 leading-relaxed">{{ $course->description }}</p>
                                    <div class="mt-4 flex items-center text-gray-600 dark:text-gray-300 text-lg">
                                        <span class="mr-4">⏱️ {{ $course->duration }} horas</span>
                                        <span class="ml-2">👨‍🏫 {{ $course->teacher->name }} {{ $course->teacher->surnames }}</span>
                                    </div>

                                    <form action="{{ route('student.courses.pickRegistration', ['courseId' => $course->id]) }}" method="POST">
                                        @csrf
                                        @if($registration)
                                            <button type="submit" class="mt-5 w-full bg-red-500 text-white py-3 rounded-lg hover:bg-red-600 transition text-lg">
                                                ❌ Cancelar Inscripción
                                            </button>
                                        @else
                                            <button type="submit" class="mt-5 w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-lg hover:from-green-600 hover:to-green-700 transition text-lg">
                                                🖊️ Inscribirme
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Paginación elegante -->
                <div class="mt-10">

                </div>
            @else
                <p class="text-center py-10 text-gray-500">No hay cursos que coincidan con la búsqueda.</p>
            @endif
        </div>
    </div>
@endsection
