<form action="{{ isset($course) ? route('admin.courses.update', $course->id) : route('admin.courses.store') }}" method="POST" class="space-y-6">
    @csrf
    @if(isset($course))
        @method('PATCH')
    @endif

    <!-- Nombre del Curso -->
    <div>
        <label for="name" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Nombre del Curso</label>
        <input type="text" name="name" id="name"
               value="{{ old('name', $course->name ?? '') }}"
               class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300" required>
    </div>

    <!-- Profesor -->
    <div>
        <label for="teacher_id" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Profesor</label>
        <select name="teacher_id" id="teacher_id"
                class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300">
            <option value="" disabled {{ isset($course) ? '' : 'selected' }}>Selecciona un profesor</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('teacher_id', $course->teacher_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} {{ $user->surnames }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Categoría -->
        <div>
            <label for="category_id" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Categoría</label>
            <select name="category_id" id="category_id"
                    class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300">
                <option value="" disabled {{ isset($course) ? '' : 'selected' }}>Selecciona una categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $course->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Estado -->
        <div>
            <label for="status" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Estado</label>
            <select name="status" id="status"
                    class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300">
                <option value="active" {{ old('status', $course->status->value ?? '') == 'active' ? 'selected' : '' }}>Activo</option>
                <option value="finalized" {{ old('status', $course->status->value ?? '') == 'finalized' ? 'selected' : '' }}>Finalizado</option>
                <option value="cancelled" {{ old('status', $course->status->value ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>
    </div>

    <!-- Duración -->
    <div>
        <label for="duration" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Duración (horas)</label>
        <input type="number" name="duration" id="duration"
               value="{{ old('duration', $course->duration ?? '') }}"
               class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300" required>
    </div>

    <!-- Descripción -->
    <div>
        <label for="description" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Descripción</label>
        <textarea name="description" id="description" rows="5"
                  class="mt-2 w-full px-5 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white transition duration-300" required>{{ old('description', $course->description ?? '') }}</textarea>
    </div>

    <!-- Botones -->
    <div class="flex justify-end gap-4 mt-10">
        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-300">
            {{ isset($course) ? 'Actualizar' : 'Guardar' }}
        </button>
        <a href="{{ route('admin.courses.index') }}" class="px-6 py-3 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-700 focus:ring-4 focus:ring-gray-400 transition duration-300">
            Cancelar
        </a>
    </div>
</form>
