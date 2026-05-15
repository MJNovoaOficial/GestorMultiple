<aside class="w-64 bg-[#0B1220] text-white min-h-screen px-4 py-4">

    {{-- Logo --}}
    <a
        href="{{ route('dashboard') }}"
        class="flex items-center justify-center pb-6 mb-6 border-b border-gray-800"
    >
        <img
            src="{{ asset('images/logo.png') }}"
            alt="MultiGestor"
            class="h-20 w-auto"
        >
    </a>

    {{-- Módulo Básicos --}}
    <div
        x-data="{ openBasic: true }"
        class="bg-[#111827] rounded-2xl p-2 shadow-lg"
    >

        {{-- Header --}}
        <button
            @click="openBasic = !openBasic"
            class="w-full flex items-center justify-between
                px-4 py-3 rounded-xl
                border border-gray-700
                bg-[#0F172A]
                hover:bg-[#1E293B]
                transition"
        >

            <div class="flex items-center gap-3">

                {{-- Icono --}}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-gray-300"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.757.426 1.757 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.757-2.924 1.757-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.757-.426-1.757-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                </svg>

                <span class="font-semibold text-sm tracking-wide">
                    Módulos Básicos
                </span>

            </div>

            {{-- Flecha --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"
                />
            </svg>

        </button>

        {{-- Submenú --}}
        <div
            x-show="openBasic"
            x-transition
            class="mt-2 space-y-1 px-2 pb-2"
        >

            <a
                href="{{ route('branches.index') }}"
                class="block px-4 py-2 rounded-lg
                       text-sm text-gray-300
                       hover:bg-gray-800
                       hover:text-white
                       transition"
            >
                Sucursales
            </a>

            <a
                href="{{ route('departments.index') }}"
                class="block px-4 py-2 rounded-lg
                       text-sm text-gray-300
                       hover:bg-gray-800
                       hover:text-white
                       transition"
            >
                Departamentos
            </a>

            <a
                href="{{ route('device-types.index') }}"
                class="block px-4 py-2 rounded-lg
                       text-sm text-gray-300
                       hover:bg-gray-800
                       hover:text-white
                       transition"
            >
                Tipos de dispositivos
            </a>

            <a
                href="{{ route('ip-statuses.index') }}"
                class="block px-4 py-2 rounded-lg
                       text-sm text-gray-300
                       hover:bg-gray-800
                       hover:text-white
                       transition"
            >
                Estados IP
            </a>

            <a
                href="{{ route('ip-ranges.create') }}"
                class="block px-4 py-2 rounded-lg
                       text-sm text-gray-300
                       hover:bg-gray-800
                       hover:text-white
                       transition"
            >
                Importar rango IP
            </a>

        </div>

    </div>

</aside>