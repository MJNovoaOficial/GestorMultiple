<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-950 text-white">
        <div class="min-h-screen flex items-center justify-center px-4">

            <div class="w-full sm:max-w-md">

                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-white">
                        Gestor IP
                    </h1>

                    <p class="text-gray-400 mt-2">
                        Administración de direcciones IP empresariales
                    </p>
                </div>

                <div class="w-full mt-6 px-6 py-6 bg-gray-900 border border-gray-800 shadow-2xl overflow-hidden sm:rounded-2xl">
                    {{ $slot }}
                </div>

            </div>

        </div>
    </body>
</html>
