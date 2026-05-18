<x-app-layout>

<div class="p-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Gestión Usuarios
            </h1>

            <p class="mt-1 text-sm text-gray-400">
                Administración de usuarios del sistema
            </p>

        </div>

        {{-- Crear Usuario --}}
        <button
            @click="openCreateUser = true"
            class="px-5 py-3 text-sm font-semibold text-white transition bg-blue-600 rounded-2xl hover:bg-blue-700 shadow-lg"
        >

            + Crear Usuario

        </button>

    </div>

    {{-- Buscador --}}
    <div class="mb-5">

        <input
            id="globalSearch"
            type="text"
            placeholder="Buscar usuario..."
            class="w-full px-4 py-3 text-white bg-gray-900 border border-gray-800 rounded-2xl
                   focus:ring-2 focus:ring-blue-500 focus:outline-none"
        >

    </div>

    {{-- Tabla --}}
    <div class="overflow-hidden bg-gray-900 border border-gray-800 rounded-2xl">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-800">

                {{-- Header --}}
                <thead class="bg-[#0F172A]">

                    <tr>

                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-400 uppercase">
                            Nombre
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-400 uppercase">
                            Correo
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-400 uppercase">
                            Rol
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-400 uppercase">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-400 uppercase">
                            Acciones
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

                                <span class="
                                    px-3 py-1 rounded-full text-xs font-semibold text-white

                                    {{ $user->role === 'superadmin'
                                        ? 'bg-red-600'
                                        : 'bg-blue-600'
                                    }}
                                ">

                                    {{ strtoupper($user->role) }}

                                </span>

                            </td>

                            {{-- Estado --}}
                            <td class="px-6 py-4">

                                <span class="
                                    px-3 py-1 rounded-full text-xs font-semibold text-white

                                    {{ $user->is_active
                                        ? 'bg-green-600'
                                        : 'bg-gray-600'
                                    }}
                                ">

                                    {{ $user->is_active ? 'ACTIVO' : 'INACTIVO' }}

                                </span>

                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-3">

                                    {{-- Editar --}}
                                    <button
                                        class="px-3 py-1 text-xs font-semibold text-white transition bg-blue-600 rounded-lg hover:bg-blue-700"
                                    >

                                        Editar

                                    </button>

                                    {{-- Eliminar --}}
                                    @if(auth()->user()->role === 'superadmin')

                                        <form
                                            method="POST"
                                            action="{{ route('users.destroy', $user) }}"
                                            onsubmit="return confirm('¿Deshabilitar usuario?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="px-3 py-1 text-xs font-semibold text-white transition bg-red-600 rounded-lg hover:bg-red-700"
                                            >

                                                Eliminar

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-8 text-sm text-center text-gray-500"
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

</div>

{{-- MODAL CREAR USUARIO --}}
<div
    x-data="{ openCreateUser: false }"
>

    <div
        x-show="openCreateUser"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70"
    >

        <div
            @click.away="openCreateUser = false"
            class="w-full max-w-lg p-6 bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl"
        >

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">

                <h2 class="text-xl font-bold text-white">
                    Crear Usuario
                </h2>

                <button
                    @click="openCreateUser = false"
                    class="text-gray-400 hover:text-white"
                >

                    ✕

                </button>

            </div>

            {{-- Form --}}
            <form
                method="POST"
                action="{{ route('users.store') }}"
                class="space-y-5"
            >

                @csrf

                {{-- Nombre --}}
                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="name"
                        required
                        class="w-full px-4 py-3 text-white bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >

                </div>

                {{-- Correo --}}
                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Correo
                    </label>

                    <input
                        type="email"
                        name="email"
                        required
                        class="w-full px-4 py-3 text-white bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >

                </div>

                {{-- Rol --}}
                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Rol
                    </label>

                    <select
                        name="role"
                        class="w-full px-4 py-3 text-white bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"
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
                <div class="p-4 text-sm text-blue-300 border border-blue-800 bg-blue-900/30 rounded-xl">

                    El usuario recibirá una contraseña temporal y deberá cambiarla en su primer inicio de sesión.

                </div>

                {{-- Submit --}}
                <div class="flex justify-center pt-3">

                    <button
                        type="submit"
                        class="px-8 py-3 font-semibold text-white transition bg-green-600 rounded-xl hover:bg-green-700"
                    >

                        Crear Usuario

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

{{-- SEARCH --}}
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