@props(['course', 'registration', 'showCancel' => true])

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

        @if($showCancel)
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
        @else
            <div class="mt-5 flex gap-4">
                <a href="{{ route('student.courses.my-course-materials', ['courseId' => $course->id]) }}"
                   class="w-full text-center px-4 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition text-lg">
                    📂 Ver Material
                </a>
            </div>
        @endif
    </div>
</div>
