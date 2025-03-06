@extends('private.components.layouts.layout')
@props(['title' => 'Evaluaciones | Administración'])

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">📋 Evaluaciones</h1>
    </div>

    @if(session('success'))
        <div class="p-4 mb-4 text-white bg-green-600 font-extrabold border border-green-400 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-4 text-white bg-red-600 font-extrabold border border-red-400 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtros -->
    <form method="GET" action="{{ route('teacher.evaluations.index') }}" class="mb-6 flex flex-col sm:flex-row gap-4">
        <!-- Campo de búsqueda por estudiante -->
        <input type="text" name="search" placeholder="Buscar por estudiante..."
               value="{{ request('search') }}"
               class="w-full sm:w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">

        <!-- Campo para curso -->
        <input type="text" name="course" placeholder="Buscar por curso..."
               value="{{ request('course') }}"
               class="w-full sm:w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">

        <!-- Filtro por estado -->
        <select name="status" class="w-full sm:w-1/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
            <option value="">Todos los estados</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Aceptado</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
        </select>

        <!-- Botón de búsqueda -->
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
            Buscar
        </button>
    </form>

    <div class="overflow-x-auto rounded-lg shadow-lg">
        @if($evaluations->count() > 0)
            <table class="min-w-full border-collapse bg-white dark:bg-gray-800">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left">Estudiante</th>
                    <th class="px-4 py-3 text-left">Curso</th>
                    <th class="px-4 py-3 text-left">Nota</th>
                    <th class="px-4 py-3 text-left">Comentarios</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 dark:divide-gray-600">
                @foreach ($evaluations as $evaluation)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                        <td class="px-4 py-3">{{ $evaluation->user->name }} {{ $evaluation->user->surnames }}</td>
                        <td class="px-4 py-3">{{ $evaluation->course->name }}</td>
                        <td class="px-4 py-3">{{ $evaluation->grade ?? 'Sin calificar' }}</td>
                        <td class="px-4 py-3">{{ $evaluation->comments ?? 'Sin comentarios' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if(auth()->user()->isAdmin() || auth()->id() === $evaluation->course->teacher_id)
                                <a href="{{ route('admin.evaluations.edit', $evaluation->id) }}"
                                   class="px-3 py-1 bg-yellow-600 text-white font-bold rounded-md text-xs hover:bg-yellow-700 transition">
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

    <div class="mt-6">
        {{ $evaluations->appends(request()->query())->links() }}
    </div>
@endsection
