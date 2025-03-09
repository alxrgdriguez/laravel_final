@extends('public.components.layouts.app')

@section('content')
    <div class="flex flex-col min-h-screen">
        <div class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <header class="mb-12 text-center">
                <h1 class="text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-700 dark:from-purple-400 dark:to-indigo-300">
                    Sobre Nosotros
                </h1>
                <p class="mt-4 text-2xl text-gray-700 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    Conoce más sobre nuestra misión, visión y valores en la educación online.
                    Somos una comunidad apasionada por el aprendizaje, comprometida con el desarrollo profesional y la excelencia académica.
                </p>
            </header>

            <section class="bg-gradient-to-r from-blue-800 to-purple-800 dark:from-gray-900 dark:to-gray-800 text-white rounded-lg shadow-2xl p-10 max-w-5xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-6">🌍 Nuestra Misión</h2>
                <p class="text-lg leading-relaxed">
                    Brindar acceso a educación de calidad a cualquier persona, en cualquier lugar, a través de tecnología avanzada y contenido especializado.
                    Creemos que el aprendizaje continuo es la clave para el éxito y trabajamos para ofrecer programas educativos actualizados y efectivos.
                </p>
            </section>

            <section class="bg-gradient-to-r from-purple-800 to-indigo-800 dark:from-gray-800 dark:to-gray-700 text-white rounded-lg shadow-2xl p-10 mt-10 max-w-5xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-6">🚀 Nuestra Visión</h2>
                <p class="text-lg leading-relaxed">
                    Convertirnos en la plataforma líder en formación profesional, ofreciendo experiencias de aprendizaje innovadoras y accesibles.
                    Queremos transformar vidas a través de la educación, proporcionando herramientas que permitan el crecimiento personal y profesional.
                </p>
            </section>

            <section class="bg-gradient-to-r from-indigo-800 to-blue-800 dark:from-gray-800 dark:to-gray-700 text-white rounded-lg shadow-2xl p-10 mt-10 max-w-5xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-6">💡 Nuestros Valores</h2>
                <ul class="list-none text-lg">
                    <li class="mb-3">📚 <span class="font-semibold">Compromiso</span> con la educación de calidad y el aprendizaje continuo.</li>
                    <li class="mb-3">🌎 <span class="font-semibold">Accesibilidad</span> y democratización del conocimiento para todos.</li>
                    <li class="mb-3">🤝 <span class="font-semibold">Colaboración</span> y comunidad, porque juntos aprendemos mejor.</li>
                    <li class="mb-3">🔬 <span class="font-semibold">Innovación</span> en metodologías de enseñanza para un aprendizaje efectivo y actualizado.</li>
                    <li class="mb-3">💡 <span class="font-semibold">Pasión por la educación</span>, impulsando el crecimiento personal y profesional.</li>
                </ul>
            </section>

            <section class="bg-gradient-to-r from-blue-800 to-indigo-800 dark:from-gray-900 dark:to-gray-800 text-white rounded-lg shadow-2xl p-10 mt-10 max-w-5xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-6">📞 Contáctanos</h2>
                <p class="text-lg leading-relaxed">
                    ¿Tienes preguntas o sugerencias? Nos encantaría escucharte.
                    Puedes contactarnos a través de nuestro correo <span class="font-semibold">soporte@fpjaroso.com</span> o nuestras redes sociales.
                </p>
            </section>
        </div>
    </div>
@endsection
