<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Acceso denegado | MultiGestor</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="max-w-xl w-full px-6">

        <div class="bg-[#020817] rounded-3xl shadow-2xl p-10 text-center">

            {{-- Icono --}}
            <div class="mb-6">

                <div class="w-24 h-24 mx-auto rounded-full
                            bg-red-500/20
                            flex items-center justify-center">

                    <span class="text-5xl">
                        🔒
                    </span>

                </div>

            </div>

            {{-- Título --}}
            <h1 class="text-4xl font-bold text-white mb-4">

                Acceso denegado

            </h1>

            {{-- Texto --}}
            <p class="text-gray-400 text-lg leading-relaxed">

                Usted no tiene autorización para acceder a este módulo del sistema.

            </p>

            <p class="text-gray-500 text-sm mt-3">

                Si cree que esto es un error, contacte al administrador.

            </p>

            {{-- Botón --}}
            <div class="mt-8">

                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center
                           px-6 py-3 rounded-xl
                           bg-indigo-600 hover:bg-indigo-700
                           text-white font-semibold
                           transition"
                >
                    Volver al dashboard
                </a>

            </div>

        </div>

    </div>

</body>

</html>