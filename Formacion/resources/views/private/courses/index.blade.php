@extends('private.components.layouts.layout')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">📚 Cursos</h1>
        @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.courses.create') }}"
               class="px-4 py-2 bg-blue-600 font-extrabold text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                Nuevo Curso
            </a>
        @endif
    </div>

    <!-- Búsqueda con botón -->
    <form method="GET" action="{{ route('admin.courses.index') }}" class="mb-4 flex flex-col sm:flex-row gap-2">
        <input type="text" name="course" value="{{ request('course') }}" placeholder="Buscar curso..."
               class="w-full p-2 border rounded-lg bg-white dark:bg-gray-800 dark:text-white">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-800 transition">
            Buscar
        </button>
    </form>

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

    @if($courses->count() > 0)
    <div class="overflow-x-auto rounded-lg shadow-lg">
        <table class="min-w-full bg-white dark:bg-gray-800" id="courses-table">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
            <tr>
                <th class="px-4 py-3 text-left">Nombre</th>
                <th class="px-4 py-3 text-left">Profesor</th>
                <th class="px-4 py-3 text-left hidden lg:table-cell">Descripción</th>
                <th class="px-4 py-3 text-left">Categoría</th>
                <th class="px-4 py-3 text-left">Estado</th>
                <th class="px-4 py-3 text-left">Duración</th>
                <th class="px-4 py-3 text-center">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-300 dark:divide-gray-600">
            @foreach ($courses as $course)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                    <td class="px-4 py-3 course-name">{{ $course->name }}</td>
                    <td class="px-4 py-3">{{ $course->teacher->name }} {{$course->teacher->surnames}}</td>
                    <td class="px-4 py-3 truncate max-w-[250px] hidden lg:table-cell">{{ $course->description }}</td>
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
                        <div class="flex flex-wrap justify-center gap-2">
                            <a href="{{ route('admin.courses.edit', $course->id) }}"
                               class="px-3 py-1 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition">
                                Editar
                            </a>

                            <button onclick="confirmDelete(this)"
                                    data-url="{{ route('admin.courses.delete', $course->id) }}"
                                    class="px-3 py-1 bg-red-600 text-white rounded-md text-xs hover:bg-red-700 transition">
                                Eliminar
                            </button>

                            @if(Auth::user()->isTeacher())
                                <a href="{{ route('admin.courses.materials.create', $course->id) }}"
                                   class="px-3 py-1 bg-green-600 text-white rounded-md text-xs hover:bg-green-700 transition">
                                    Material
                                </a>
                            @endif

                            <button onclick="confirmFinalize(this)"
                                    data-url="{{ route('admin.courses.finalize', $course->id) }}"
                                    class="px-3 py-1 text-white rounded-md text-xs transition
                                        {{ $course->status->value === 'finalized' ? 'bg-gray-500 cursor-not-allowed' : 'bg-gray-900 hover:bg-gray-800' }}"
                                    @if($course->status->value === 'finalized') disabled title="Este curso ya ha sido finalizado" @endif>
                                {{ $course->status->value === 'finalized' ? 'Finalizado' : 'Finalizar' }}
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @else
        <p class="text-center py-10 text-gray-500">No hay cursos disponibles en este momento.</p>
    @endif
    <div class="mt-6">
        {{ $courses->links() }}
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("search");
            const searchButton = document.getElementById("search-btn");
            const tableRows = document.querySelectorAll("#courses-table tbody tr");

            function filterCourses() {
                const searchText = searchInput.value.toLowerCase();

                tableRows.forEach(row => {
                    const courseName = row.querySelector(".course-name").textContent.toLowerCase();
                    row.style.display = courseName.includes(searchText) ? "" : "none";
                });
            }

            searchInput.addEventListener("keyup", function(event) {
                if (event.key === "Enter") {
                    filterCourses();
                }
            });

            searchButton.addEventListener("click", function() {
                filterCourses();
            });
        });

        function confirmDelete(button) {
            const url = button.getAttribute('data-url');

            Swal.fire({
                title: "¿Estás seguro que deseas eliminar este curso?",
                text: "No podrás revertir esta acción",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.action = url;
                    form.method = 'POST';
                    form.innerHTML = `@csrf @method('DELETE')`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function confirmFinalize(button) {
            const url = button.getAttribute('data-url');

            Swal.fire({
                title: "¿Deseas finalizar este curso?",
                text: "Una vez finalizado, no podrá reactivarse.",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#4CAF50",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, finalizar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.action = url;
                    form.method = 'POST';
                    form.innerHTML = `@csrf @method('PATCH')`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
