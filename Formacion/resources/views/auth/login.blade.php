<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('favicon.png')}}" type="image/x-icon">
    <title>Iniciar Sesión - FP Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen p-6">

<div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 w-full max-w-md">
    <!-- Logo y título -->
    <div class="text-center mb-6">
        <img src="{{ asset('imgs/logo.png') }}" alt="Moodle FP Online" class="h-24 mx-auto">
        <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">Iniciar Sesion</h2>
    </div>

    <!-- Mensaje de sesión -->
    @if (session('status'))
        <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 p-3 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <!-- Formulario -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Correo Electrónico -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 dark:text-gray-300 font-semibold">Correo Electrónico</label>
            <input type="email" placeholder="micorreo@gmail.com" id="email" name="email" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none" required autofocus>
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700 dark:text-gray-300 font-semibold">Contraseña</label>
            <input type="password" placeholder="********" id="password" name="password" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none" required>
            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Recuérdame y Olvidé mi contraseña -->
        <div class="flex items-center justify-between mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-600 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-gray-100 dark:bg-gray-700">
                <span class="ml-2 text-gray-600 dark:text-gray-300">Recuérdame</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-indigo-500 dark:text-indigo-400 hover:underline text-sm">¿Olvidaste tu contraseña?</a>
            @endif
        </div>

        <!-- Botón de Login -->
        <button type="submit" class="w-full bg-indigo-600 dark:bg-indigo-500 text-white p-3 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition">
            Iniciar Sesión
        </button>
    </form>

    <!-- Registro -->
    <div class="text-center mt-4">
        <p class="text-gray-600 dark:text-gray-300">¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-indigo-500 dark:text-indigo-400 hover:underline">Regístrate aquí</a>
        </p>
    </div>
</div>

</body>
</html>
