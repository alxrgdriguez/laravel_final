@extends('private.components.layouts.layout')
@props(['title' => 'Inicio | Evaluaciones'])
@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">📝 Evaluaciones</h1>
    </div>

    <!-- Alertas de éxito o error -->
    @if(session('success'))
        <div class="p-4 mb-4 text-white bg-green-600 font-extrabold rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-4 text-white bg-red-600 font-extrabold rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtros -->
    <form method="GET" action="{{ route('admin.evaluations.index') }}" class="mb-6 flex flex-col sm:flex-row gap-4">
        <!-- Búsqueda por estudiante -->
        <input type="text" name="student" placeholder="Buscar estudiante..."
               value="{{ request('student') }}"
               class="w-full sm:w-1/3 px-4 py-2 rounded-lg border dark:bg-gray-800 dark:text-white">

        <!-- Búsqueda por curso -->
        <input type="text" name="course" placeholder="Buscar curso..."
               value="{{ request('course') }}"
               class="w-full sm:w-1/3 px-4 py-2 rounded-lg border dark:bg-gray-800 dark:text-white">

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
            Buscar
        </button>
    </form>

    <!-- Tabla de Evaluaciones -->
    <div class="overflow-x-auto rounded-lg shadow-lg">
        @if($registrations->count())
            <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left">Estudiante</th>
                    <th class="px-4 py-3 text-left">Curso</th>
                    <th class="px-4 py-3 text-center">Nota</th>
                    <th class="px-4 py-3 text-left">Comentarios</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                @foreach ($registrations as $registration)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3">{{ $registration->user->name }} {{ $registration->user->surnames }}</td>
                        <td class="px-4 py-3">{{ $registration->course->name }}</td>
                        <td class="px-4 py-3 text-center">{{ $registration->evaluation()->final_note ?? 'Sin calificar' }}</td>
                        <td class="px-4 py-3 truncate max-w-[200px] dark:text-white">{{ $registration->evaluation()->comments ?? 'Sin comentarios' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if(auth()->user()->isAdmin() || auth()->id() === $registration->course->teacher_id)
                                <a href="{{ route('admin.evaluations.edit', $registration->id) }}"
                                   class="px-3 py-1 bg-yellow-500 text-black rounded-lg text-xs font-bold hover:bg-yellow-600 transition">
                                    Evaluar
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center py-10 text-gray-500">No hay evaluaciones para mostrar.</p>
        @endif
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $registrations->appends(request()->query())->links() }}
    </div>
@endsection
