@extends('private.components.layouts.layout')
@props(['title' => 'Editar Evaluación'])

@section('content')
    <div class="flex items-center justify-center py-12">
        <div class="max-w-2xl w-full bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 border border-gray-300 dark:border-gray-700">
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-gray-100 mb-8">📝 Editar Evaluación</h1>

            <form action="{{ route('admin.evaluations.update', $registration->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Nombre del estudiante (solo lectura) -->
                <div>
                    <label class="block text-lg font-medium text-gray-700 dark:text-gray-300">Estudiante</label>
                    <input type="text" readonly value="{{ $registration->user->name }} {{ $registration->user->surnames }}"
                           class="w-full px-4 py-3 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 rounded-lg cursor-not-allowed">
                </div>

                <!-- Nombre del curso (solo lectura) -->
                <div>
                    <label class="block text-lg font-medium text-gray-700 dark:text-gray-300">Curso</label>
                    <input type="text" readonly value="{{ $registration->course->name }}"
                           class="w-full px-4 py-3 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 rounded-lg cursor-not-allowed">
                </div>

                <!-- Nota Final -->
                <div>
                    <label for="final_note" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Nota Final</label>
                    <input type="number" step="0.1" min="0" max="10" id="final_note" name="final_note"
                           value="{{ old('final_note', $registration->final_note) }}"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-4 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    @error('final_note')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Comentarios -->
                <div>
                    <label for="comments" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Comentarios</label>
                    <textarea id="comments" name="comments" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-4 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">{{ old('comments', $registration->comments) }}</textarea>
                    @error('comments')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-4">
                    <button type="submit"
                            class="px-5 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                        Guardar Cambios
                    </button>
                    <a href="{{ route('admin.evaluations.index') }}"
                       class="px-5 py-3 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
