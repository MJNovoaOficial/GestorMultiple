<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <script>

            // Tema guardado
            if (
                localStorage.getItem('theme') === 'dark'
            ) {

                document.documentElement.classList.add('dark');

            }

        </script>
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="
        bg-slate-100 dark:bg-[#0F172A]
        text-slate-900 dark:text-white
        transition-colors duration-300
    ">

        <div class="flex min-h-screen">

            {{-- Sidebar --}}
            <x-sidebar />

            {{-- Content --}}
            <main class="
                flex-1 p-6
                bg-slate-100 dark:bg-[#0F172A]
                text-slate-900 dark:text-white
                transition-colors duration-300
            ">
                {{ $slot }}
            </main>

            <style>
                [x-cloak] {
                    display: none !important;
                }
            </style>
        </div>
    <script>
            const savedTheme = localStorage.getItem('theme');

            if (savedTheme === 'dark') {

                document.documentElement.classList.add('dark');

            } else {

                document.documentElement.classList.remove('dark');

            }
        </script>
    </body>
</html>