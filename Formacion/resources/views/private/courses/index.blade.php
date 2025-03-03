@extends('private.components.layouts.layout')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">📚 Cursos</h1>
        <!-- Mostrar el botón solo si el usuario es administrador -->
        @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.courses.create') }}"
               class="px-4 py-2 bg-blue-600 font-extrabold text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                Nuevo Curso
            </a>
        @endif
    </div>

    <div class="overflow-x-auto rounded-lg shadow-lg">
        @if ($courses->count())
            <table class="min-w-full border-collapse bg-white dark:bg-gray-800">
                <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Profesor</th>
                    <th class="px-4 py-3 text-left">Descripción</th>
                    <th class="px-4 py-3 text-left">Categoría</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-left">Duración</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 dark:divide-gray-600">
                @foreach ($courses as $course)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                        <td class="px-4 py-3">{{ $course->name }}</td>
                        <td class="px-4 py-3">{{ $course->teacher->name }}</td>
                        <td class="px-4 py-3 truncate max-w-[200px]">{{ $course->description }}</td>
                        <td class="px-4 py-3">{{ $course->category->name }}</td>
                        <td class="px-4 py-3">
                            @php
                                $statusColors = [
                                    'active' => 'bg-green-700 text-white',
                                    'cancelled' => 'bg-red-700 text-white',
                                    'finalized' => 'bg-gray-700 text-white',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-lg {{ $statusColors[$course->status->value] ?? 'bg-gray-200 text-gray-800' }}">
                                    {{ ucfirst($course->status->value) }}
                                </span>
                        </td>
                        <td class="px-4 py-3">{{ $course->duration }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <!-- Botón Editar -->
                                <a href="" class="px-3 py-1 w-24 bg-blue-600 font-bold text-white rounded-md text-xs hover:bg-blue-700 transition text-center">
                                    Editar
                                </a>
                                <!-- Botón Eliminar -->
                                <form action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 w-24 bg-red-600 font-bold text-white rounded-md text-xs hover:bg-red-700 transition text-center">
                                        Eliminar
                                    </button>
                                </form>
                                <!-- Botón Finalizar / Finalizado -->
                                <form action="" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="px-3 py-1 w-24 text-white font-bold rounded-md text-xs transition text-center
                                            {{ $course->status->value === 'finalized' ? 'bg-gray-500 cursor-not-allowed' : 'bg-gray-900 hover:bg-gray-900' }}"
                                            @if($course->status->value === 'finalized') disabled title="Este curso ya ha sido finalizado" @endif
                                    >
                                        {{ $course->status->value === 'finalized' ? 'Finalizado' : 'Finalizar' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center py-10 text-gray-500">No hay cursos disponibles.</p>
        @endif
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $courses->links() }}
    </div>
@endsection
