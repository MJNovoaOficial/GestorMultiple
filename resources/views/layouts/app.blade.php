<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
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
<body class="bg-gray-100">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <x-sidebar />

        {{-- Content --}}
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    </div>
    <script>

        document.addEventListener('submit', function (event) {

            const form = event.target;

            const submitButtons = form.querySelectorAll(
                'button[type="submit"]'
            );

            submitButtons.forEach(button => {

                // Evitar múltiples submits
                button.disabled = true;

                // Guardar texto original
                if (!button.dataset.originalText) {

                    button.dataset.originalText =
                        button.innerHTML;

                }

                // Texto loading
                button.innerHTML = 'Procesando...';

                // Estilos visuales
                button.classList.add(
                    'opacity-50',
                    'cursor-not-allowed'
                );

            });

        });

        const themeToggle =
        document.getElementById('themeToggle');

        if (themeToggle) {

            themeToggle.addEventListener(
                'click',
                () => {

                    document.documentElement
                        .classList.toggle('dark');

                    // Guardar preferencia
                    if (
                        document.documentElement
                        .classList.contains('dark')
                    ) {

                        localStorage.setItem(
                            'theme',
                            'dark'
                        );

                    } else {

                        localStorage.setItem(
                            'theme',
                            'light'
                        );

                    }

                }
            );

        }

    </script>
</body>
</html>