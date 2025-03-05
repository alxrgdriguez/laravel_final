@extends('private.components.layouts.layout')
@props(['title' => 'Inicio | Inscripciones'])
@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">📋 Inscripciones</h1>
    </div>

    <!-- Alertas -->
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

    <form method="GET" action="{{ route('admin.registrations.index') }}" class="mb-6 flex flex-col sm:flex-row gap-4">
        <!-- Filtro por estado -->
        <select name="status" class="w-full sm:w-1/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
            <option value="pending" {{ request('status', 'pending') == 'pending' ? 'selected' : '' }}>Pendientes</option>
            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Aceptadas</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Canceladas</option>
        </select>

        <!-- Botón de búsqueda -->
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
            Filtrar
        </button>
    </form>

    <div class="overflow-x-auto rounded-lg shadow-lg">
        @if ($registrations->count() > 0)
            <table class="min-w-full border-collapse bg-white dark:bg-gray-800">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left">Estudiante</th>
                    <th class="px-4 py-3 text-left">Curso</th>
                    <th class="px-4 py-3 text-left">Fecha de inscripción</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 dark:divide-gray-600">
                @foreach ($registrations as $registration)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                        <td class="px-4 py-3">{{ $registration->user->name }} {{ $registration->user->surnames }}</td>
                        <td class="px-4 py-3">{{ $registration->course->name }}</td>
                        <td class="px-4 py-3">{{ $registration->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-600 text-white',
                                    'accepted' => 'bg-green-600 text-white',
                                    'cancelled' => 'bg-red-600 text-white',
                                ];
                            @endphp

                            <span class="px-2 py-1 text-xs font-semibold rounded-lg {{ $statusColors[$registration->statusReg->value] ?? 'bg-gray-500 text-white' }}">
                    {{ ucfirst($registration->statusReg->value) }}
                </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                @if($registration->user->isAdmin() || auth()->id() === $registration->course->teacher_id)
                                    @if($registration->statusReg->value === 'pending')
                                        <form action="{{ route('admin.registrations.accept', $registration->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 bg-green-600 font-bold text-white rounded-md text-xs hover:bg-green-700 transition">
                                                Aceptar
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.registrations.cancelled', $registration->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 bg-red-600 font-bold text-white rounded-md text-xs hover:bg-red-700 transition">
                                                Rechazar
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center py-10 text-gray-500">No hay inscripciones pendientes.</p>
        @endif
    </div>

    <div class="mt-6">
        {{ $registrations->appends(request()->query())->links() }}
    </div>

@endsection
