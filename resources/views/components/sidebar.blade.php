<aside class="
    w-72

    bg-[#020817]
    text-white

    h-screen

    px-3 py-6 pt-4

    sticky
    top-0

    overflow-y-auto
    overflow-x-hidden
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
            px-4 py-2.5 rounded-2xl
            bg-slate-900/80 whitespace-nowrap
            dark:border-slate-800
            hover:bg-[#1E293B]
            transition
            shadow-lg"
    >

        {{-- Icono --}}
        
        <span class="font-semibold text-sm tracking-wide text-white">
           👤 Usuarios
        </span>

    </a>


    {{-- Módulo Gestor IP --}}
    <div
        x-data="{ openIp: false }"
        class="bg-slate-900/80 rounded-2xl shadow-lg overflow-hidden"
    >

        {{-- Header --}}
        <button
            @click="openIp = !openIp"
            class="w-full flex items-center justify-between
                px-4 py-2.5 rounded-none
                bg-slate-900/80 whitespace-nowrap
                dark:border-slate-800
                hover:bg-[#1E293B]
                transition"
        >

            <div class="flex items-center gap-3">

                {{-- Icono --}}
                <span class="font-semibold text-sm tracking-wide">
                   🌐 Módulo Gestor IP
                </span>

            </div>

            {{-- Flecha --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-gray-400 shrink-0"
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
            class="border-t border-slate-800 px-4 py-3 space-y-1"
        >

            {{-- Listado IPs --}}
            <a
                href="{{ route('ip-addresses.index') }}"
                class="block px-4 py-2 rounded-xl
                    text-sm text-gray-300
                    hover:bg-[#1E293B]
                    hover:text-white
                    transition-all duration-200"
            >
                Listado IPs
            </a>

            {{-- Importador --}}
            <a
                href="{{ route('ip-ranges.create') }}"
                class="block px-4 py-2 rounded-xl
                    text-sm text-gray-300
                    hover:bg-[#1E293B]
                    hover:text-white
                    transition-all duration-200"
            >
                Importar rango IP
            </a>

        </div>

    </div>

    {{-- Módulo Gestor Contraseñas --}}
    <div
        x-data="{ openPasswords: false }"
        class="bg-slate-900/80 rounded-2xl shadow-lg overflow-hidden"
    >

        {{-- Header --}}
        <button
            @click="openPasswords = !openPasswords"
            class="w-full flex items-center justify-between
                px-4 py-2.5 rounded-none
                bg-slate-900/80 whitespace-nowrap
                dark:border-slate-800
                hover:bg-[#1E293B]
                transition"
        >

            <div class="flex items-center gap-3">

                {{-- Icono --}}
                <span class="font-semibold text-sm tracking-wide">
                    🔐 Módulo Gestor Contraseñas
                </span>

            </div>

            {{-- Flecha --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-gray-400 shrink-0"
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
            class="border-t border-slate-800 px-4 py-3 space-y-1"
        >

            {{-- Listado Contraseñas --}}
            <a
                href="{{ route('passwords.index') }}"
                class="block px-4 py-2 rounded-xl
                    text-sm text-gray-300
                    hover:bg-[#1E293B]
                    hover:text-white
                    transition-all duration-200"
            >
                Listado de Contraseñas
            </a>

            {{-- Asignar Contraseña --}}
            <a
                href="{{ route('passwords.create') }}"
                class="block px-4 py-2 rounded-xl
                    text-sm text-gray-300
                    hover:bg-[#1E293B]
                    hover:text-white
                    transition-all duration-200"
            >
                Asignar Contraseña
            </a>

        </div>

    </div>
    
    {{-- Gestión Suministros --}}
    <div
        x-data="{
            open: window.location.pathname.includes('supplies')
        }"
        class="bg-slate-900/80 rounded-2xl shadow-lg overflow-hidden"
    >

        {{-- Header --}}
        <button
            @click="open = !open"
            class="
                w-full flex items-center justify-between
                    px-4 py-2.5 rounded-none
                    bg-slate-900/80 whitespace-nowrap
                    dark:border-slate-800
                    hover:bg-[#1E293B]
                    transition
            "
        >

            <div class="flex items-center gap-3">

                {{-- Icon --}}
                <span class="font-semibold text-sm tracking-wide">
                    📦 Gestión Suministros
                </span>

            </div>

            {{-- Arrow --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 text-slate-400 transition-transform duration-300 shrink-0"
                :class="{ 'rotate-180': open }"
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

        {{-- Content --}}
        <div
            x-show="open"
            x-transition
            class="
                border-t border-slate-800
                px-5 py-4
                space-y-3
            "
        >

            <a
                href="{{ route('supplies.index') }}"
                class="
                    block px-4 py-2 rounded-xl
                    text-sm text-gray-300
                    hover:bg-[#1E293B]
                    hover:text-white
                    transition-all duration-200
                "
            >
                Listado Suministros
            </a>

            <a
                href="{{ route('supplies.create') }}"
                class="
                    block px-4 py-2 rounded-xl
                    text-sm text-gray-300
                    hover:bg-[#1E293B]
                    hover:text-white
                    transition-all duration-200
                "
            >
                Registrar Suministro
            </a>

        </div>

    </div>
    {{-- Modulo Dispositivos --}}
    <div x-data="{ openDevices: false }" class="bg-slate-900/80 rounded-2xl shadow-lg overflow-hidden">

        <button
            @click="openDevices = !openDevices"

            class="w-full flex items-center justify-between
                    px-4 py-2.5 rounded-none
                    bg-slate-900/80 whitespace-nowrap
                    dark:border-slate-800
                    hover:bg-[#1E293B]
                    transition
            "
        >

            <span class="font-semibold text-sm tracking-wide
            ">
                📱 Gestion de Dispositivos

            </span>

            <svg
                class="
                    w-4 h-4
                    transition-transform
                "

                class="shrink-0"
                :class="{
                    'rotate-180': openDevices
                }"

                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"
                />

            </svg>

        </button>

        {{-- SUBMENÚ --}}
        <div
            x-show="openDevices"
            x-transition

            class="
                mt-2 ml-4
                flex flex-col gap-1
            "
        >

            <a
                href="{{ route('employee-phones.index') }}"

                class="
                    px-4 py-2
                    rounded-lg

                    text-sm

                    hover:bg-slate-800/60

                    transition
                "
            >

                Celulares

            </a>
            <a
                href="{{ route('notebooks.index') }}"

                class="
                    px-4 py-2
                    rounded-lg

                    text-sm

                    hover:bg-slate-800/60

                    transition
                "
            >

                Notebooks

            </a>
            <a
                href="{{ route('radio-frequencies.index') }}"

                class="
                    px-4 py-2
                    rounded-lg

                    text-sm

                    hover:bg-slate-800/60

                    transition
                "
            >

                Radiofrecuencias

            </a>

        </div>

    </div>

     {{-- Módulo Básicos --}}
    @if(auth()->user()->role === 'superadmin')
        <div
            x-data="{ openBasic: false }"
            class="bg-slate-900/80 rounded-2xl shadow-lg overflow-hidden"
        >

            {{-- Header --}}
            <button
                @click="openBasic = !openBasic"
                class="w-full flex items-center justify-between
                    px-4 py-2.5 rounded-none
                    bg-slate-900/80 whitespace-nowrap
                    dark:border-slate-800
                    hover:bg-[#1E293B]
                    transition"
                    
            >

                <div class="flex items-center gap-3">

                    {{-- Icono --}}
                    <span class="font-semibold text-sm tracking-wide">
                       ⚙️ Módulos Básicos
                    </span>

                </div>

                {{-- Flecha --}}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 text-gray-400 shrink-0"
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
                class="border-t border-slate-800 px-4 py-2.5 space-y-1"
            >

                <a
                    href="{{ route('branches.index') }}"
                    class="block px-4 py-2 rounded-xl
                        text-sm text-gray-300
                        hover:bg-[#1E293B]
                        hover:text-white
                        transition-all duration-200"
                >
                    Sucursales
                </a>

                <a
                    href="{{ route('departments.index') }}"
                    class="block px-4 py-2 rounded-xl
                        text-sm text-gray-300
                        hover:bg-[#1E293B]
                        hover:text-white
                        transition-all duration-200"
                >
                    Departamentos
                </a>

                <a
                    href="{{ route('device-types.index') }}"
                    class="block px-4 py-2 rounded-xl
                        text-sm text-gray-300
                        hover:bg-[#1E293B]
                        hover:text-white
                        transition-all duration-200"
                >
                    Tipos de dispositivos
                </a>

                <a
                    href="{{ route('ip-statuses.index') }}"
                    class="block px-4 py-2 rounded-xl
                        text-sm text-gray-300
                        hover:bg-[#1E293B]
                        hover:text-white
                        transition-all duration-200"
                >
                    Estados IP
                </a>

            </div>

        </div>
    @endif

    {{-- Auditoría --}}
        <a
            href="{{ route('audits.index') }}"
            class="flex items-center gap-3
                px-4 py-2.5 rounded-2xl
                bg-slate-900/80 whitespace-nowrap
                dark:border-slate-800
                hover:bg-[#1E293B]
                transition
                shadow-lg"
        >

            {{-- Icono --}}
            <span class="font-semibold text-sm tracking-wide text-white">
              📋 Auditoría
            </span>

        </a>

    <!-- Toggle Tema -->
    <div class="flex justify-center mt-6 mb-8">

        <button
            id="theme-toggle"
            class="relative flex items-center
            w-16 h-10 p-1
            rounded-full
            bg-slate-700
            transition-all duration-300"
        >

            <!-- Circle -->
            <div
                id="toggle-circle"
                class="absolute right-1
                flex items-center justify-center
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
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 12.79A9 9 0 1111.21 3c0 .34.02.67.05 1A7 7 0 0021 12.79z"
                    />
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
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364l-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0-1.414 1.414M7.05 16.95l-1.414 1.414M12 8a4 4 0 100 8 4 4 0 000-8"
                    />
                </svg>

            </div>

        </button>

    </div>
    
    {{-- Footer Sidebar --}}
    <div class="mt-auto px-4 pb-6 space-y-3">

        <a
            href="{{ route('profile.edit') }}"
            class="
                flex items-center gap-3
                px-4 py-3
                rounded-2xl

                bg-slate-800/60
                hover:bg-slate-700/70

                border border-slate-700/50

                transition
            "
        >

            @if(auth()->user()->profile_photo)

                <img
                    src="/storage/{{ auth()->user()->profile_photo }}"
                    alt="Foto perfil"

                    class="
                        w-10 h-10
                        rounded-full
                        object-cover
                        border border-slate-700
                    "
                >

            @else

                <div class="
                    w-10 h-10
                    rounded-full

                    bg-blue-600

                    flex items-center
                    justify-center

                    text-white font-bold
                ">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

            @endif

            <div class="flex flex-col">

                <span class="
                    text-sm font-semibold
                    text-white
                ">

                    {{ auth()->user()->name }}

                </span>

                <span class="
                    text-xs
                    text-slate-400
                    uppercase
                ">

                    {{ auth()->user()->role }}

                </span>

            </div>

        </a>

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
                    px-4 py-2.5 rounded-2xl
                    bg-red-900/40
                    hover:bg-red-800/50
                    border border-red-500/20
                    text-red-400
                    transition
                    font-medium
                "
            >

                {{-- Icon --}}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6"
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