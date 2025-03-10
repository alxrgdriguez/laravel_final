@extends('public.components.layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Nueva Sección: Generar Token de API -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">🔑 Generar Token de API</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Genera un token de API para usar con tu cuenta.</p>

                <form id="generate-token-form" action="{{ route('profile.generate-token') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-800 transition">
                        Generar Token
                    </button>
                </form>

                <!-- Mostrar el token generado -->
                <div id="token-container" class="mt-4 hidden">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Tu token de API generado:</p>
                    <div class="relative">
                        <input type="text" id="api-token" class="w-full p-2 border rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white" readonly>
                        <button onclick="copyToken()" class="absolute top-0 right-0 px-3 py-2 bg-gray-600 text-white rounded-lg text-sm hover:bg-gray-700">
                            Copiar
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('generate-token-form').addEventListener('submit', async function(event) {
            event.preventDefault();
            const response = await fetch("{{ route('profile.generate-token') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            });

            if (response.ok) {
                const data = await response.json();
                document.getElementById('api-token').value = data.token;
                document.getElementById('token-container').classList.remove('hidden');
            } else {
                alert("Error al generar el token.");
            }
        });

        function copyToken() {
            const tokenInput = document.getElementById('api-token');
            tokenInput.select();
            document.execCommand("copy");
            alert("Token copiado al portapapeles.");
        }
    </script>

@endsection
