@extends('public.components.layouts.app')

@section('content')
    <div class="flex flex-col min-h-screen">
        <div class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <header class="mb-12 text-center">
                <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-700 dark:from-purple-400 dark:to-indigo-300">
                    Mis Cursos
                </h1>
                <p class="mt-4 text-xl text-gray-700 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Aquí puedes ver los cursos en los que estás inscrito.
                </p>
            </header>

            @if($courses->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach($courses as $course)
                        <x-course-card :course="$course" :registration="true" :showCancel="false" />
                    @endforeach
                </div>
            @else
                <p class="text-center py-10 text-gray-500">No estás inscrito en ningún curso.</p>
            @endif
        </div>
    </div>
@endsection
