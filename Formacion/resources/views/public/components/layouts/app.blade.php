<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Plataforma de Cursos')</title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex flex-col min-h-screen">

{{-- Navbar --}}
@include('public.components.layouts.navbar')

<main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @yield('content') {{-- Aquí se inyecta el contenido de cada vista --}}
</main>

{{-- Footer--}}
@include('public.components.layouts.footer')

</body>
</html>
