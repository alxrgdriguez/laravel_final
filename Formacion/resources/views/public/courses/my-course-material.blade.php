@extends('public.components.layouts.app')

@section('content')
    <div class="container mx-auto p-8">
        <!-- Encabezado -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">
                📚 Materiales del Curso: <span class="text-indigo-500">{{ $course->name }}</span>
            </h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2 text-lg">
                Explora los materiales de este curso y mejora tu aprendizaje.
            </p>
        </div>

        <!-- Si no hay materiales -->
        @if($materials->isEmpty())
            <div class="flex justify-center items-center h-64">
                <p class="text-gray-500 dark:text-gray-400 text-lg">
                    ⚠️ No hay materiales disponibles para este curso.
                </p>
            </div>
        @else
            <!-- Lista de Materiales -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($materials as $material)
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden transition hover:scale-105 transform duration-300 p-5">
                        <!-- Icono y Nombre del Material -->
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                @switch($material->type)
                                    @case(App\Enums\MaterialType::PDF)
                                        📄 <span class="ml-2">Documento PDF</span>
                                        @break
                                    @case(App\Enums\MaterialType::VIDEO)
                                        🎥 <span class="ml-2">Video</span>
                                        @break
                                    @case(App\Enums\MaterialType::URL)
                                        🔗 <span class="ml-2">Enlace</span>
                                        @break
                                    @case(App\Enums\MaterialType::REPOSITORY)
                                        🗂 <span class="ml-2">Repositorio</span>
                                        @break
                                @endswitch
                            </h2>
                        </div>

                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
                            <span class="font-semibold text-indigo-500">{{ $material->title }}</span>
                        </p>

                        <!-- Contenedor de Vista y Descarga -->
                        <div class="mt-4 flex flex-col space-y-3">
                            @if($material->type === App\Enums\MaterialType::PDF || $material->type === App\Enums\MaterialType::URL)
                                <a href="{{ asset('storage/' . $material->url) }}"
                                   class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition w-full text-center font-semibold"
                                   target="_blank">
                                    📖 Ver Material
                                </a>
                            @endif

                            @if($material->type === App\Enums\MaterialType::VIDEO)
                                <video controls class="w-full rounded-lg shadow-md">
                                    <source src="{{ asset('storage/' . $material->url) }}" type="video/mp4">
                                    Tu navegador no soporta la reproducción de videos.
                                </video>
                            @endif

                            <!-- Botón de Descarga (Todos los archivos tienen uno) -->
                            <a href="{{ asset('storage/' . $material->url) }}"
                               class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition w-full text-center font-semibold"
                               download>
                                📥 Descargar
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Botón para volver -->
        <div class="text-center mt-10">
            <a href="{{ route('student.courses.my-courses') }}"
               class="inline-flex items-center px-6 py-3 bg-gray-600 text-white text-lg font-semibold rounded-lg shadow-md hover:bg-gray-700 transition">
                🔙 Volver a Mis Cursos
            </a>
        </div>
    </div>
@endsection
