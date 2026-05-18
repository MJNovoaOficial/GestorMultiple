<aside class="
    bg-slate-100 dark:bg-[#020817]
    text-slate-900 dark:text-white
    min-h-screen
">

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

    {{-- Módulo Usuarios --}}
    <a
        href="{{ route('users.index') }}"
        class="flex items-center gap-3
            px-4 py-3 rounded-2xl
            bg-white dark:bg-[#111827]
            border border-slate-200 dark:border-slate-800
            hover:bg-slate-100 dark:hover:bg-[#1E293B]
            transition
            shadow-lg
            mb-4"
    >

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
                d="M17 20h5V4H2v16h5m10 0v-2
                a4 4 0 00-4-4H9a4 4 0 00-4 4v2m12 0H5
                m12 0a2 2 0 002-2V6a2 2 0 00-2-2H7
                a2 2 0 00-2 2v12a2 2 0 002 2m6-12
                a2 2 0 11-4 0 2 2 0 014 0z"
            />
        </svg>

        <span class="font-semibold text-sm tracking-wide text-white">
            Usuarios
        </span>

    </a>


    {{-- Módulo Gestor IP --}}
    <div
        x-data="{ openIp: true }"
        class="bg-white dark:bg-[#111827] rounded-2xl p-2 shadow-lg mb-4"
    >

        {{-- Header --}}
        <button
            @click="openIp = !openIp"
            class="w-full flex items-center justify-between
                px-4 py-3 rounded-xl
                bg-white dark:bg-[#111827]
                border border-slate-200 dark:border-slate-800
                hover:bg-slate-100 dark:hover:bg-[#1E293B]
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
                        d="M3 5h18M9 3v2m6-2v2M4 9h16v10H4V9z"
                    />
                </svg>

                <span class="font-semibold text-sm tracking-wide">
                    Módulo Gestor IP
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

        {{-- Submenu --}}
        <div
            x-show="openIp"
            x-transition
            class="mt-2 space-y-1 px-2 pb-2"
        >

            {{-- Listado IPs --}}
            <a
                href="{{ route('ip-addresses.index') }}"
                class="block px-4 py-2 rounded-lg
                    text-sm text-gray-300
                    hover:bg-gray-800
                    hover:text-white
                    transition"
            >
                Listado IPs
            </a>

            {{-- Importador --}}
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

    {{-- Módulo Gestor Contraseñas --}}
    <div
        x-data="{ openPasswords: true }"
        class="bg-white dark:bg-[#111827] rounded-2xl p-2 shadow-lg mb-4"
    >

        {{-- Header --}}
        <button
            @click="openPasswords = !openPasswords"
            class="w-full flex items-center justify-between
                px-4 py-3 rounded-xl
                bg-white dark:bg-[#111827]
                border border-slate-200 dark:border-slate-800
                hover:bg-slate-100 dark:hover:bg-[#1E293B]
                transition"
        >

            <div class="flex items-center gap-3">

                {{-- Icono --}}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 text-gray-300"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2h-1V9a5 5 0 00-10 0v2H6a2 2 0 00-2 2v6a2 2 0 002 2z"
                    />
                </svg>

                <span class="font-semibold text-sm tracking-wide">
                    Módulo Gestor Contraseñas
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

        {{-- Submenu --}}
        <div
            x-show="openPasswords"
            x-transition
            class="mt-2 space-y-1 px-2 pb-2"
        >

            {{-- Listado Contraseñas --}}
            <a
                href="{{ route('passwords.index') }}"
                class="block px-4 py-2 rounded-lg
                    text-sm text-gray-300
                    hover:bg-gray-800
                    hover:text-white
                    transition"
            >
                Listado de Contraseñas
            </a>

            {{-- Asignar Contraseña --}}
            <a
                href="{{ route('passwords.create') }}"
                class="block px-4 py-2 rounded-lg
                    text-sm text-gray-300
                    hover:bg-gray-800
                    hover:text-white
                    transition"
            >
                Asignar Contraseña
            </a>

        </div>

    </div>
    {{-- Auditoría --}}
    <a
        href="{{ route('audits.index') }}"
        class="flex items-center gap-3 mb-4
            px-4 py-3 rounded-2xl
            bg-white dark:bg-[#111827]
            border border-slate-200 dark:border-slate-800
            hover:bg-slate-100 dark:hover:bg-[#1E293B]
            transition
            shadow-lg"
    >

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
                d="M9 17v-6m3 6V7m3 10v-4m3 8H6a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2z"
            />
        </svg>

        <span class="font-semibold text-sm tracking-wide text-white">
            Auditoría
        </span>

    </a>

    {{-- Módulo Básicos --}}
    @if(auth()->user()->role === 'superadmin')
        <div
            x-data="{ openBasic: true }"
            class="bg-white dark:bg-[#111827] rounded-2xl p-2 shadow-lg"
        >

            {{-- Header --}}
            <button
                @click="openBasic = !openBasic"
                class="w-full flex items-center justify-between
                    px-4 py-3 rounded-xl
                    bg-white dark:bg-[#111827]
                    border border-slate-200 dark:border-slate-800
                    hover:bg-slate-100 dark:hover:bg-[#1E293B]
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

            </div>

        </div>
    @endif
    <!-- Toggle Tema -->
    <div class="flex justify-center mt-6 mb-8">
        <button
            id="theme-toggle"
            class="relative flex items-center w-20 h-10 px-1
            rounded-full
            bg-slate-700
            transition-all duration-300"
        >
            <!-- Label -->
            <span
                id="toggle-label"
                class="absolute left-3 text-[10px] font-bold tracking-wider uppercase
                text-slate-300 transition-all duration-300"
            >
                Dark
            </span>

            <!-- Circle -->
            <div
                id="toggle-circle"
                class="absolute right-1 flex items-center justify-center
                w-8 h-8 rounded-full
                bg-slate-800
                shadow-md
                transition-all duration-300"
            >
                <!-- Moon -->
                <svg
                    id="moon-icon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 text-indigo-300"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 12.79A9 9 0 1111.21 3c0 .34.02.67.05 1A7 7 0 0021 12.79z"/>
                </svg>

                <!-- Sun -->
                <svg
                    id="sun-icon"
                    xmlns="http://www.w3.org/2000/svg"
                    class="hidden w-4 h-4 text-yellow-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364l-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0-1.414 1.414M7.05 16.95l-1.414 1.414M12 8a4 4 0 100 8 4 4 0 000-8"/>
                </svg>
            </div>
        </button>
    </div>

    {{-- Footer Sidebar --}}
    <div class="mt-auto px-4 pb-6 space-y-3">

        {{-- Logout --}}
        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="
                    w-full flex items-center gap-3
                    px-4 py-3 rounded-2xl
                    bg-red-600/20
                    hover:bg-red-600/30
                    border border-red-500/20
                    text-red-400
                    transition
                    font-medium
                "
            >

                {{-- Icon --}}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1
                        a2 2 0 01-2 2H6a2 2 0 01-2-2V7
                        a2 2 0 012-2h5a2 2 0 012 2v1"
                    />
                </svg>

                <span>
                    Cerrar sesión
                </span>

            </button>

        </form>

    </div>
</aside>