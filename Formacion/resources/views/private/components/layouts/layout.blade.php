@props(['title' => 'Inicio | Cursos'])

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex text-white">

<!-- Sidebar -->
<aside class="w-64 bg-white dark:bg-gray-800 min-h-screen p-4 shadow-lg flex flex-col justify-between">
    <!-- Título -->
    <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 text-center">📊 Dashboard</h2>


    <!-- Navegación -->
    <nav class="mt-6 space-y-2 flex-1">
        <a href="{{ route('admin.courses.index') }}"
           class="flex items-center gap-2 p-4 text-lg font-medium text-gray-700 dark:text-gray-300 rounded-lg transition
                  hover:bg-gray-200 dark:hover:bg-gray-700
                  {{ request()->routeIs('admin.courses.index') ? 'bg-gray-300 dark:bg-gray-700' : '' }}">
            📚 <span>Cursos</span>
        </a>

        <a href="{{ route('admin.registrations.index') }}"
           class="flex items-center gap-2 p-4 text-lg font-medium text-gray-700 dark:text-gray-300 rounded-lg transition
                  hover:bg-gray-200 dark:hover:bg-gray-700
                  {{ request()->routeIs('admin.registrations.index') ? 'bg-gray-300 dark:bg-gray-700' : '' }}">
            📝 <span>Inscripciones</span>
        </a>

        <a href="{{ route('admin.evaluations.index') }}"
           class="flex items-center gap-2 p-4 text-lg font-medium text-gray-700 dark:text-gray-300 rounded-lg transition
                  hover:bg-gray-200 dark:hover:bg-gray-700
                  {{ request()->routeIs('admin.evaluations.index') ? 'bg-gray-300 dark:bg-gray-700' : '' }}">
            🎓 <span>Evaluaciones</span>
        </a>

        @if(Auth::user()->isAdmin())
        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-2 p-4 text-lg font-medium text-gray-700 dark:text-gray-300 rounded-lg transition
                  hover:bg-gray-200 dark:hover:bg-gray-700
                  {{ request()->routeIs('admin.users.index') ? 'bg-gray-300 dark:bg-gray-700' : '' }}">
            👥 <span>Usuarios</span>
        </a>
        @endif
        @if(Auth::user()->isAdmin())
            <a href="{{ route('student.courses.index') }}"
               class="flex items-center gap-2 p-4 text-lg font-medium text-gray-700 dark:text-gray-300 rounded-lg transition
              hover:bg-gray-200 dark:hover:bg-gray-700
              {{ request()->routeIs('student.courses.index') ? 'bg-gray-300 dark:bg-gray-700' : '' }}">
                🌐 <span>Web Students</span>
            </a>

        @endif

        @can('manage-users')
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-2 p-4 text-lg font-medium text-red-600 dark:text-red-400 rounded-lg transition
                      hover:bg-gray-200 dark:hover:bg-gray-700
                      {{ request()->routeIs('admin.users.index') ? 'bg-gray-300 dark:bg-gray-700' : '' }}">
                👥 <span>Usuarios</span>
            </a>
        @endcan
    </nav>

    <!-- Dropdown del usuario -->
    <div class="relative">
        <button onclick="toggleDropdown()" class="w-full flex items-center justify-between px-4 py-3 bg-gray-200 dark:bg-gray-700 rounded-lg text-lg font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
            <span> 👤 {{ Auth::user()->name }}</span>
            <svg class="fill-current h-4 w-4 transition-transform duration-200" id="dropdown-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>

        <!-- Contenido del dropdown -->
        <div id="dropdown-menu" class="absolute bottom-12 left-0 w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-2 hidden">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">⚙️ Mi cuenta</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">🚪 Cerrar sesión</button>
            </form>
        </div>
    </div>
</aside>

<!-- Contenido -->
<main class="flex-1 p-6">
    @yield('content')
</main>

<!-- Script para mostrar el dropdown hacia arriba -->
<script>
    function toggleDropdown() {
        const menu = document.getElementById('dropdown-menu');
        const icon = document.getElementById('dropdown-icon');
        menu.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }

    // Cerrar dropdown al hacer clic fuera
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdown-menu');
        const button = document.querySelector('button[onclick="toggleDropdown()"]');
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
            document.getElementById('dropdown-icon').classList.remove('rotate-180');
        }
    });
</script>

</body>
</html>
