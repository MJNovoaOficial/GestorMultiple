<x-app-layout>

<div
    x-data="{ openCreateUser: false }"
    class="p-6"
>

    {{-- Header --}}
    <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">

        <div>

            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                Gestión Usuarios
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Administración de usuarios del sistema
            </p>

            @if(auth()->user()->role === 'superadmin')

            <div class="flex gap-3 mt-5 mb-6">

                {{-- Activos --}}
                <a
                    href="{{ route('users.index', ['status' => 'active']) }}"
                    class="
                        px-5 py-2 rounded-xl text-sm font-semibold
                        transition

                        {{ $status === 'active'
                            ? 'bg-blue-600 text-white shadow-lg'
                            : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                        }}
                    "
                >

                    Activos

                </a>

                {{-- Inactivos --}}
                <a
                    href="{{ route('users.index', ['status' => 'inactive']) }}"
                    class="
                        px-5 py-2 rounded-xl text-sm font-semibold
                        transition

                        {{ $status === 'inactive'
                            ? 'bg-red-600 text-white shadow-lg'
                            : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
                        }}
                    "
                >

                    Inactivos

                </a>

            </div>

        @endif

        </div>

        {{-- Botón Crear --}}
        <button
            @click="openCreateUser = true"
            class="px-5 py-3 text-sm font-semibold text-white
                transition bg-blue-600 rounded-2xl
                hover:bg-blue-700 shadow-lg"
        >

            Nuevo Usuario

        </button>

    </div>

    {{-- Alertas --}}
    @if(session('success'))

        <div class="
            mb-5 px-4 py-3 rounded-xl
            bg-green-600 text-white text-sm
        ">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="
            mb-5 px-4 py-3 rounded-xl
            bg-red-600 text-white text-sm
        ">

            {{ session('error') }}

        </div>

    @endif

    {{-- Buscador --}}
    <div class="mb-5">

        <input
            id="globalSearch"
            type="text"
            placeholder="Buscar usuario..."
            class="w-full px-4 py-3
                text-white bg-gray-900
                border border-gray-800
                rounded-2xl
                focus:ring-2 focus:ring-blue-500
                focus:outline-none"
        >

    </div>

    {{-- Tabla --}}
    <div class="
        overflow-hidden
        bg-gray-900
        border border-gray-800
        rounded-2xl
    ">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-800">

                {{-- Header --}}
                <thead class="bg-[#0F172A]">

                    <tr>

                        <th class="
                            px-6 py-4 text-xs font-semibold
                            tracking-wider text-left
                            text-gray-400 uppercase
                        ">
                            Nombre
                        </th>

                        <th class="
                            px-6 py-4 text-xs font-semibold
                            tracking-wider text-left
                            text-gray-400 uppercase
                        ">
                            Correo
                        </th>

                        <th class="
                            px-6 py-4 text-xs font-semibold
                            tracking-wider text-left
                            text-gray-400 uppercase
                        ">
                            Rol
                        </th>

                        <th class="
                            px-6 py-4 text-xs font-semibold
                            tracking-wider text-left
                            text-gray-400 uppercase
                        ">
                            Estado
                        </th>

                    </tr>

                </thead>

                {{-- Body --}}
                <tbody class="divide-y divide-gray-800">

                    @forelse($users as $user)

                        <tr
                            class="user-row hover:bg-gray-800/40 transition"

                            data-search="
                                {{ strtolower($user->name) }}
                                {{ strtolower($user->email) }}
                            "
                        >

                            {{-- Nombre --}}
                            <td class="px-6 py-4 text-sm text-white">

                                {{ $user->name }}

                            </td>

                            {{-- Correo --}}
                            <td class="px-6 py-4 text-sm text-gray-300">

                                {{ $user->email }}

                            </td>

                            {{-- Rol --}}
                            <td class="px-6 py-4">

                                @if(
                                    auth()->user()->role === 'superadmin'
                                    && auth()->id() !== $user->id
                                )

                                    <form
                                        method="POST"
                                        action="{{ route('users.update', $user) }}"
                                    >

                                        @csrf
                                        @method('PUT')

                                        <input
                                            type="hidden"
                                            name="type"
                                            value="role"
                                        >

                                        <select
                                            name="role"
                                            onchange="this.form.submit()"
                                            class="
                                                px-3 py-1 rounded-full
                                                text-xs font-semibold
                                                bg-gray-800 border border-gray-700
                                                text-white
                                                focus:outline-none
                                            "
                                        >

                                            <option
                                                value="admin"
                                                {{ $user->role === 'admin' ? 'selected' : '' }}
                                            >
                                                ADMIN
                                            </option>

                                            <option
                                                value="superadmin"
                                                {{ $user->role === 'superadmin' ? 'selected' : '' }}
                                            >
                                                SUPERADMIN
                                            </option>

                                        </select>

                                    </form>

                                @else

                                    <span class="
                                        px-3 py-1 rounded-full
                                        text-xs font-semibold text-white

                                        {{ $user->role === 'superadmin'
                                            ? 'bg-red-600'
                                            : 'bg-blue-600'
                                        }}
                                    ">

                                        {{ strtoupper($user->role) }}

                                    </span>

                                @endif

                            </td>

                            {{-- Estado --}}
                            <td class="px-6 py-4">

                                @if(auth()->id() !== $user->id)

                                    <form
                                        method="POST"
                                        action="{{ route('users.update', $user) }}"
                                    >

                                        @csrf
                                        @method('PUT')

                                        <input
                                            type="hidden"
                                            name="type"
                                            value="status"
                                        >

                                        <select
                                            name="is_active"
                                            onchange="this.form.submit()"
                                            class="
                                                px-3 py-1 rounded-full
                                                text-xs font-semibold
                                                bg-gray-800 border border-gray-700
                                                text-white
                                                focus:outline-none
                                            "
                                        >

                                            <option
                                                value="1"
                                                {{ $user->is_active ? 'selected' : '' }}
                                            >
                                                Activo
                                            </option>

                                            <option
                                                value="0"
                                                {{ !$user->is_active ? 'selected' : '' }}
                                            >
                                                Eliminar
                                            </option>

                                        </select>

                                    </form>

                                @else

                                    <span class="
                                        px-3 py-1 rounded-full
                                        text-xs font-semibold
                                        bg-green-600 text-white
                                    ">

                                        ACTIVO

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="
                                    px-6 py-8 text-sm
                                    text-center text-gray-500
                                "
                            >

                                No existen usuarios registrados.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Paginación --}}
    <div class="mt-6">

        {{ $users->links() }}

    </div>

    {{-- MODAL CREAR USUARIO --}}
    <div
        x-show="openCreateUser"
        x-transition
        x-cloak
        class="
            fixed inset-0 z-50
            flex items-center justify-center
            bg-black/60 backdrop-blur-sm
        "
    >

        <div
            @click.away="openCreateUser = false"
            class="
                w-full max-w-xl
                bg-[#0B1220]
                border border-gray-800
                rounded-3xl
                shadow-2xl
                p-8
            "
        >

            {{-- Header --}}
            <div class="
                flex items-center justify-between
                mb-6
            ">

                <div>

                    <h2 class="text-2xl font-bold text-white">
                        Crear Usuario
                    </h2>

                    <p class="text-sm text-gray-400 mt-1">
                        Nuevo acceso administrativo
                    </p>

                </div>

                {{-- Cerrar --}}
                <button
                    @click="openCreateUser = false"
                    class="
                        text-gray-400 hover:text-white
                        text-xl transition
                    "
                >

                    ✕

                </button>

            </div>

            {{-- Formulario --}}
            <form
                method="POST"
                action="{{ route('users.store') }}"
                class="space-y-5"
            >

                @csrf

                {{-- Nombre --}}
                <div>

                    <label class="
                        block mb-2 text-sm text-gray-300
                    ">
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="name"
                        required
                        class="
                            w-full px-4 py-3
                            text-white
                            bg-gray-800
                            border border-gray-700
                            rounded-2xl
                            focus:ring-2 focus:ring-blue-500
                            focus:outline-none
                        "
                    >

                </div>

                {{-- Correo --}}
                <div>

                    <label class="
                        block mb-2 text-sm text-gray-300
                    ">
                        Correo
                    </label>

                    <input
                        type="email"
                        name="email"
                        required
                        class="
                            w-full px-4 py-3
                            text-white
                            bg-gray-800
                            border border-gray-700
                            rounded-2xl
                            focus:ring-2 focus:ring-blue-500
                            focus:outline-none
                        "
                    >

                </div>

                {{-- Rol --}}
                <div>

                    <label class="
                        block mb-2 text-sm text-gray-300
                    ">
                        Rol
                    </label>

                    <select
                        name="role"
                        class="
                            w-full px-4 py-3
                            text-white
                            bg-gray-800
                            border border-gray-700
                            rounded-2xl
                            focus:ring-2 focus:ring-blue-500
                            focus:outline-none
                        "
                    >

                        <option value="admin">
                            Admin
                        </option>

                        @if(auth()->user()->role === 'superadmin')

                            <option value="superadmin">
                                Superadmin
                            </option>

                        @endif

                    </select>

                </div>

                {{-- Info --}}
                <div
                    class="
                        flex items-start gap-3
                        p-4 rounded-2xl
                        border border-yellow-300
                    "
                    style="
                        background-color: #FFF2CC;
                    "
                >

                    {{-- Icono --}}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 mt-0.5 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        style="color: #B45309;"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v2m0 4h.01M10.29 3.86l-7.5 13
                            A1 1 0 003.66 18h16.68a1 1 0 00.87-1.5l-7.5-13
                            a1 1 0 00-1.74 0z"
                        />
                    </svg>

                    {{-- Texto --}}
                    <p
                        class="text-sm leading-relaxed"
                        style="color: #78350F;"
                    >

                        El usuario recibirá una contraseña temporal
                        y deberá cambiarla en su primer inicio de sesión.

                    </p>

                </div>
                {{-- Botón --}}
                <div class="flex justify-center pt-2">

                    <button
                        type="submit"
                        class="
                            px-10 py-3
                            min-w-[220px]
                            bg-green-600
                            hover:bg-green-700
                            transition
                            rounded-2xl
                            text-white
                            font-semibold
                            shadow-lg
                            text-sm
                            tracking-wide
                        "
                    >

                        Crear Usuario

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

{{-- Buscador --}}
<script>

    const globalSearch = document.getElementById('globalSearch');

    globalSearch.addEventListener('input', () => {

        const value = globalSearch.value.toLowerCase();

        document.querySelectorAll('.user-row').forEach(row => {

            const content = row.dataset.search;

            row.style.display = content.includes(value)
                ? ''
                : 'none';

        });

    });

</script>

</x-app-layout>