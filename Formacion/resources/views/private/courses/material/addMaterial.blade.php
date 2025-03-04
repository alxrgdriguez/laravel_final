@extends('private.components.layouts.layout')
@props(['title' => 'Material | Curso'])
@section('content')
    <div class="flex items-center justify-center bg-gradient-to-b from-gray-100 to-gray-300 dark:from-gray-800 dark:to-gray-900 py-12">
        <div class="max-w-xl w-full bg-white dark:bg-gray-900 shadow-lg rounded-2xl p-8 border border-gray-300 dark:border-gray-700">
            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">
                📂 Añadir Material al Curso
            </h1>

            @if(session('success'))
                <div class="p-4 mb-4 text-white bg-green-600 font-extrabold border border-green-400 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.courses.materials.store', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Tipo de Material -->
                <div>
                    <label for="type" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Tipo de Material</label>
                    <select name="type" id="type" required
                            class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300">
                        <option value="" disabled selected>Selecciona el tipo de material</option>
                        <option value="pdf">📄 PDF</option>
                        <option value="video">🎥 Video</option>
                        <option value="url">🔗 URL</option>
                        <option value="repository">📂 Repositorio</option>
                    </select>
                </div>

                <!-- Subida de Archivo -->
                <div>
                    <label class="block text-lg font-medium text-gray-700 dark:text-gray-300">Subir Archivo</label>
                    <input type="file" name="file" required class="w-full mt-2 px-4 py-3 border rounded-lg dark:bg-gray-800 dark:text-white">
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-4 mt-6">
                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Agregar Material</button>
                        <a href="/" class="px-5 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
