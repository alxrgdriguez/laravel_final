<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - FP Online</title>
    <link rel="shortcut icon" href="{{asset('favicon.png')}}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen p-6">

<div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 w-full max-w-md">
    <!-- Logo y título -->
    <div class="text-center mb-6">
        <img src="{{ asset('imgs/logo.png') }}" alt="Moodle FP Online" class="h-24 mx-auto">
        <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200 mt-4">Registrarse</h2>
    </div>

    <!-- Mensajes de sesión -->
    @if (session('status'))
        <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 p-3 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <!-- Formulario de Registro -->
    <form method="POST" action="{{ route('register') }}" class="w-full max-w-sm">
        @csrf

        <!-- DNI -->
        <div class="mb-4">
            <label for="dni" class="block text-gray-700 dark:text-gray-300 font-semibold">DNI</label>
            <input type="text" id="dni" placeholder="01234567A" name="dni" minlength="9" maxlength="9"
                   class="w-full p-3 border border-gray-400 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                          focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none
                          @error('dni') border-red-500 @enderror"
                   required>
            @error('dni') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Nombre -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 dark:text-gray-300 font-semibold">Nombre</label>
            <input type="text" placeholder="Manolo" id="name" name="name"
                   class="w-full p-3 border border-gray-400 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                          focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none
                          @error('name') border-red-500 @enderror"
                   required>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Apellidos -->
        <div class="mb-4">
            <label for="surnames" class="block text-gray-700 dark:text-gray-300 font-semibold">Apellidos</label>
            <input type="text" placeholder="Perez Castro" id="surnames" name="surnames"
                   class="w-full p-3 border border-gray-400 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                          focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none
                          @error('surnames') border-red-500 @enderror"
                   required>
            @error('surnames') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Correo Electrónico -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 dark:text-gray-300 font-semibold">Correo Electrónico</label>
            <input type="email" placeholder="ejemplo@ejemplo.com" id="email" name="email"
                   class="w-full p-3 border border-gray-400 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                          focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none
                          @error('email') border-red-500 @enderror"
                   required>
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700 dark:text-gray-300 font-semibold">Contraseña</label>
            <input type="password" placeholder="********" id="password" name="password"
                   class="w-full p-3 border border-gray-400 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none @error('password') border-red-500 @enderror"
                   required>
            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300 font-semibold">Confirmar Contraseña</label>
            <input type="password" placeholder="********" id="password_confirmation" name="password_confirmation"
                   class="w-full p-3 border border-gray-400 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none @error('password_confirmation') border-red-500 @enderror"
                   required>
            @error('password_confirmation') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Teléfono -->
        <div class="mb-4">
            <label for="phone_number" class="block text-gray-700 dark:text-gray-300 font-semibold">Teléfono</label>
            <input type="number" placeholder="567843267" id="phone_number" name="phone_number" maxlength="9"
                   class="w-full p-3 border border-gray-400 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none @error('phone_number') border-red-500 @enderror"
                   required>
            @error('phone_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Dirección -->
        <div class="mb-4">
            <label for="address" class="block text-gray-700 dark:text-gray-300 font-semibold">Dirección</label>
            <input type="text" placeholder="Calle 123" id="address" name="address"
                   class="w-full p-3 border border-gray-400 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none @error('address') border-red-500 @enderror"
                   required>
            @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Ciudad -->
        <div class="mb-4">
            <label for="city" class="block text-gray-700 dark:text-gray-300 font-semibold">Ciudad</label>
            <input  type="text" placeholder="Madrid" id="city" name="city"
                   class="w-full p-3 border border-gray-400 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 outline-none"
                   required>

        </div>

        <!-- Rol (Predefinido como "student" y bloqueado) -->
        <input hidden type="text" id="role" name="role" value="student" readonly>

        <!-- Botón de Registro -->
        <button type="submit" class="w-full bg-indigo-600 dark:bg-indigo-500 text-white p-3 rounded-lg
                                   hover:bg-indigo-700 dark:hover:bg-indigo-600 transition">
            Registrarse
        </button>

        <!-- Login -->
        <div class="text-center mt-4">
            <p class="text-gray-600 dark:text-gray-300">¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-indigo-500 dark:text-indigo-400 hover:underline">Iniciar sesión aquí</a>
            </p>
        </div>

    </form>
</div>

</body>
</html>



