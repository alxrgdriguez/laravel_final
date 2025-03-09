@extends('private.components.layouts.layout')
@props(['title' => 'Usuarios | Administrador'])
@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">👥 Usuarios</h1>
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

    <!-- Filtros -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6 flex flex-col sm:flex-row gap-4">
        <input type="text" name="search" placeholder="Buscar por nombre..."
               value="{{ request('search') }}"
               class="w-full sm:w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">

        <select name="role" class="w-full sm:w-1/4 px-4 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
            <option value="">Todos los roles</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>Profesor</option>
            <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Estudiante</option>
        </select>

        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
            Buscar
        </button>
    </form>

    <!-- Tabla de Usuarios -->
    <div class="overflow-x-auto rounded-lg shadow-lg">
        @if ($users->count() > 0)
            <table class="min-w-full border-collapse bg-white dark:bg-gray-800">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Rol Actual</th>
                    <th class="px-4 py-3 text-left">Modificar Rol</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 dark:divide-gray-600">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                        <td class="px-4 py-3">{{ $user->name }} {{ $user->surnames }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>

                        <!-- Rol Actual -->
                        <td class="px-4 py-3">
                            @php
                                $roleColors = [
                                    'admin' => 'bg-blue-700 font-extrabold text-white',
                                    'teacher' => 'bg-yellow-600 font-extrabold text-black',
                                    'student' => 'bg-green-700 font-extrabold text-white',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-lg {{ $roleColors[$user->role->value] ?? 'bg-gray-500 text-white' }}">
                                {{ ucfirst($user->role->value) }}
                            </span>
                        </td>

                        <!-- Modificar Rol -->
                        <td class="px-4 py-3">
                            <form action="{{route('admin.users.update', $user->id)}}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="role" class="px-2 py-1 text-xs font-semibold border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white"
                                        onchange="this.form.submit()">
                                    <option value="" disabled selected>Selecciona un rol</option>
                                    <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Estudiante</option>
                                    <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Profesor</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                        </td>

                        <td class="px-4 py-3 text-center">
                            <div class="flex flex-col md:flex-row justify-center items-center space-y-2 md:space-x-2 md:space-y-0">
                                <!-- Botón Eliminar -->
                                <button onclick="confirmDelete(this)"
                                        data-url="{{ route('admin.users.delete', $user->id) }}"
                                        class="px-3 py-1 w-full md:w-24 bg-red-600 font-bold text-white rounded-md text-xs hover:bg-red-700 transition text-center">
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center py-10 text-gray-500">No hay usuarios que coincidan con la búsqueda.</p>
        @endif
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $users->appends(request()->query())->links() }}
    </div>

    <!-- Script para eliminar usuario -->
    <script>
        function confirmDelete(button) {
            const url = button.getAttribute('data-url');

            Swal.fire({
                title: "¿Estás seguro que deseas eliminar este usuario?",
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
    </script>
@endsection
