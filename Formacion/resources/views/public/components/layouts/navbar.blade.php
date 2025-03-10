<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-800 via-indigo-800 to-purple-800 dark:from-gray-900 dark:to-gray-800 shadow-xl py-4">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center space-x-6">
                <!-- Logo -->
                <a href="{{ route('index') }}" class="flex items-center text-white font-bold text-xl hover:text-yellow-400 transition">
                    <img src="{{ asset('imgs/login-img.png') }}" alt="Cursos Online" class="h-12 w-auto">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex space-x-8 text-lg font-semibold">
                @if(Auth::user() && Auth::user()->isStudent() || Auth::user()->isAdmin())
                <x-nav-link :href="route('student.courses.index')" :active="request()->routeIs('student.courses.index')" class="text-white hover:text-purple-400 transition">
                 <p class="text-2xl font-semibold">🏠 Inicio</p>
                </x-nav-link>
                @endif

                @if(Auth::user() && Auth::user()->isAdmin() || Auth::user() && Auth::user()->isTeacher())
                    <x-nav-link :href="route('index')"  class="text-white hover:text-purple-400 transition">
                       <p class="text-2xl font-semibold">📊 Dashboard</p>
                    </x-nav-link>
                @endif

                @if(Auth::user() && Auth::user()->isStudent())
                    <x-nav-link :href="route('student.courses.my-courses')" :active="request()->routeIs('student.courses.my-courses')" class="text-white hover:text-purple-400 transition">
                        <p class="text-2xl font-semibold">📚 Mis Cursos</p>
                    </x-nav-link>
                @endif

                <x-nav-link :href="route('student.nosotros.index')" :active="request()->routeIs('student.nosotros.index')" class="text-white hover:text-purple-400 transition">
                    <p class="text-2xl font-semibold">👨‍🎓 Nosotros</p>
                </x-nav-link>
            </div>

            <!-- User Menu -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center px-4 py-2 border border-transparent text-lg font-semibold rounded-lg text-white bg-gray-800 hover:bg-gray-700 focus:outline-none transition">
                                👤 <span class="ml-2">{{ Auth::user()->name }}</span>
                                <svg class="ml-2 h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="text-gray-800 dark:text-white text-md">
                                ⚙️ Mi Cuenta
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    🚪 Cerrar Sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="text-white hover:text-yellow-400 p-3 rounded-lg focus:outline-none transition">
                    <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-show="open" class="sm:hidden bg-gray-900 text-white p-5 text-lg max-h-[400px] overflow-hidden transition-all ease-in-out duration-300">
        <x-nav-link :href="route('index')" :active="request()->routeIs('index')" class="block py-3 font-semibold">🏠 Inicio</x-nav-link>

        @if(Auth::user() && Auth::user()->isAdmin())
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block py-3 font-semibold">📊 Dashboard</x-nav-link>
        @endif

        @if(Auth::user() && Auth::user()->isStudent())
            <x-nav-link :href="route('student.courses.index')" :active="request()->routeIs('student.courses.index')" class="block py-3 font-semibold">📚 Mis Cursos</x-nav-link>
        @endif

        <div class="border-t border-gray-700 my-3"></div>

        @auth
            <x-nav-link :href="route('profile.edit')" class="block py-3 font-semibold">⚙️ Configuración</x-nav-link>
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <x-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                    🚪 Cerrar Sesión
                </x-nav-link>
            </form>
        @endauth
    </div>
</nav>
