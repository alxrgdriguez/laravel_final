<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Moodle Cursos')</title>
    <link rel="shortcut icon" href="{{asset('favicon.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1200)" class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex flex-col min-h-screen">

<!-- Pantalla de carga -->
<div x-show="loading" class="fixed inset-0 flex items-center justify-center bg-white dark:bg-gray-900 z-50">
    <div class="flex flex-col items-center">
        <img src="{{ asset('imgs/logo.png') }}" class="h-20 w-auto animate-pulse" alt="Cargando...">
        <p class="mt-4 text-lg text-gray-700 dark:text-gray-300">Cargando...</p>
    </div>
</div>

{{-- Navbar --}}
@include('public.components.layouts.navbar')

<main x-show="!loading" class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12 transition-opacity duration-500">
    @yield('content') {{-- Aquí se inyecta el contenido de cada vista --}}
</main>

{{-- Footer--}}
@include('public.components.layouts.footer')

</body>

</html>
