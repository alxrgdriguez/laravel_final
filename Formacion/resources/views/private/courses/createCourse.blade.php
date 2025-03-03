@extends('private.components.layouts.layout')
@props(['title' => 'Nuevo | Curso'])
@section('content')
    <div class="flex items-center justify-center bg-gradient-to-b from-gray-100 to-gray-300 dark:from-gray-800 dark:to-gray-900 py-12">
        <div class="max-w-xl w-full bg-white dark:bg-gray-900 shadow-lg rounded-2xl p-8 border border-gray-300 dark:border-gray-700 min-h-[750px] flex flex-col justify-center">
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-10">
                📚 Nuevo Curso
            </h1>

            <form action="{{route('admin.courses.store')}}" method="POST" class="space-y-6">
                @csrf

                <!-- Nombre del Curso -->
                <div>
                    <label for="name" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Nombre del Curso</label>
                    <input type="text" name="name" id="name" class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300" required>
                </div>

                <!-- Profesor -->
                <div>
                    <label for="teacher_id" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Profesor</label>
                    <select name="teacher_id" id="teacher_id" class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300">
                        <option value="" disabled selected>Selecciona un profesor</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Categoría -->
                    <div>
                        <label for="category_id" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Categoría</label>
                        <select name="category_id" id="category_id" class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300">
                            <option value="" disabled selected>Selecciona una categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="status" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Estado</label>
                        <select name="status" id="status" class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300">
                            <option value="active">Activo</option>
                            <option value="finalized">Finalizado</option>
                            <option value="cancelled">Cancelado</option>
                        </select>
                    </div>
                </div>

                <!-- Duración -->
                <div>
                    <label for="duration" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Duración (horas)</label>
                    <input type="number" name="duration" id="duration" class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300" required>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="description" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                    <textarea name="description" id="description" rows="5" class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300" required></textarea>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-4 mt-10">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-300">
                        Guardar
                    </button>
                    <a href="/" class="px-6 py-3 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-700 focus:ring-4 focus:ring-gray-400 transition duration-300">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
