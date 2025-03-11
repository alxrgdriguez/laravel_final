<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - FP Online</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen p-6">
<div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 w-full max-w-md">
    <!-- Logo y título -->
    <div class="text-center mb-6">
        <img src="{{ asset('imgs/logo.png') }}" alt="Moodle FP Online" class="h-24 mx-auto">
        <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">Recuperar Contraseña</h2>
    </div>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
        {{ __('Olvidaste tu contraseña? No hay problema. Ingresa tu correo y te enviaremos un enlace para restablecerla.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="w-full max-w-sm mx-auto">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 dark:text-gray-300 font-semibold">Correo Electrónico</label>
            <input type="email" id="email" name="email" placeholder="ejemplo@ejemplo.com"
                   class="w-full p-3 border border-gray-400 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                              focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none"
                   required autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="w-full bg-indigo-600 dark:bg-indigo-500 text-white p-3 rounded-lg
                                       hover:bg-indigo-700 dark:hover:bg-indigo-600 transition">
            {{ __('Enviar enlace de restablecimiento') }}
        </button>

        <div class="text-center mt-4">
            <p class="text-gray-600 dark:text-gray-300">¿Recordaste tu contraseña?
                <a href="{{ route('login') }}" class="text-indigo-500 dark:text-indigo-400 hover:underline">Iniciar sesión aquí</a>
            </p>
        </div>
    </form>
</div>
</body>
</html>
