<x-app-layout>

<div class="p-6">

    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-700 dark:text-slate-200">
                Listado de Contraseñas
            </h1>

            <p class="text-sm text-slate-500 dark:text-slate-400">
                Gestión de credenciales corporativas
            </p>
        </div>

    </div>

    @if(session('success'))
        <div class="px-4 py-3 mb-4 text-green-200 bg-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="p-4 mb-4 bg-gray-900 rounded-xl">

        <form method="GET"
              action="{{ route('passwords.index') }}"
              class="grid grid-cols-1 gap-4 md:grid-cols-4">

            <div>
                <input
                    type="text"
                    id="globalSearch"
                    value="{{ request('search') }}"
                    placeholder="Buscar..."
                    class="w-full px-4 py-2 text-white bg-gray-800 border border-gray-700 rounded-lg focus:ring focus:ring-blue-500"
                >
            </div>

            <div>
                <select
                    name="branch_id"
                    class="w-full px-4 py-2 text-white bg-gray-800 border border-gray-700 rounded-lg">

                    <option value="">Todas las sucursales</option>

                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}"
                            @selected(request('branch_id') == $branch->id)>
                            {{ $branch->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <select
                    name="department_id"
                    class="w-full px-4 py-2 text-white bg-gray-800 border border-gray-700 rounded-lg">

                    <option value="">Todos los departamentos</option>

                    @foreach($departments as $department)
                        <option value="{{ $department->id }}"
                            @selected(request('department_id') == $department->id)>
                            {{ $department->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <button
                    type="submit"
                    class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">

                    Filtrar

                </button>
            </div>

        </form>

    </div>

    <div class="overflow-hidden bg-gray-900 rounded-xl">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-800">

                <thead class="bg-gray-800">

                    <tr>

                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">
                            Nombre
                        </th>

                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">
                            Correo
                        </th>

                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">
                            Password
                        </th>

                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">
                            Sucursal
                        </th>

                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-400 uppercase">
                            Departamento
                        </th>

                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-400 uppercase">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-800">

                    @forelse($passwords as $password)

                        <tr
                            class="password-row hover:bg-gray-800/50"

                            data-search="
                                {{ strtolower($password->full_name) }}
                                {{ strtolower($password->email) }}
                            "
                        >

                            <td class="px-6 py-4 text-sm text-white">
                                {{ $password->full_name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-300">
                                {{ $password->email }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-300">

                                <div
                                    x-data="passwordReveal({{ $password->id }})"
                                    class="flex items-center gap-3"
                                >

                                    <span x-text="revealed ? password : '••••••••••••••'"></span>

                                    <button
                                        type="button"
                                        @click="toggleReveal()"
                                        class="text-gray-400 hover:text-white transition"
                                    >

                                        <span x-show="!revealed">

                                            {{-- Ojo abierto --}}
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
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                                                    c4.478 0 8.268 2.943 9.542 7
                                                    -1.274 4.057-5.064 7-9.542 7
                                                    -4.477 0-8.268-2.943-9.542-7z"
                                                />
                                            </svg>

                                        </span>

                                        <span x-show="revealed">

                                            {{-- Ojo tachado --}}
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
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19
                                                    c-4.478 0-8.268-2.943-9.542-7
                                                    a9.956 9.956 0 012.293-3.95m3.123-2.342
                                                    A9.953 9.953 0 0112 5c4.478 0 8.268 2.943
                                                    9.542 7a9.97 9.97 0 01-4.293 5.774
                                                    M15 12a3 3 0 00-4.878-2.121
                                                    M3 3l18 18"
                                                />
                                            </svg>

                                        </span>

                                    </button>

                                </div>

                            </td>

                            <td class="px-6 py-4 text-sm text-gray-300">
                                {{ $password->branch?->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-300">
                                {{ $password->department?->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-right">

                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('passwords.edit', $password) }}"
                                       class="px-3 py-1 text-xs text-white bg-yellow-600 rounded hover:bg-yellow-700">
                                        Regenerar
                                    </a>

                                    <form method="POST"
                                          action="{{ route('passwords.destroy', $password) }}"
                                          onsubmit="return confirm('¿Eliminar credencial?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-3 py-1 text-xs text-white bg-red-600 rounded hover:bg-red-700">

                                            Eliminar
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-6 py-6 text-sm text-center text-gray-400">

                                No hay credenciales registradas.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-4">
        {{ $passwords->links() }}
    </div>

</div>
<script>

    // BUSCADOR GLOBAL

    const globalSearch = document.getElementById('globalSearch');

    globalSearch.addEventListener('input', () => {

        const value = globalSearch.value.toLowerCase();

        document.querySelectorAll('.password-row').forEach(row => {

            const content = row.dataset.search;

            row.style.display = content.includes(value)
                ? ''
                : 'none';

        });

    });


    function passwordReveal(id) {

        return {

            revealed: false,

            password: '',

            async toggleReveal() {

                if (this.revealed) {

                    this.revealed = false;

                    return;
                }

                try {

                    const response = await fetch(
                        `/passwords/${id}/reveal`,
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            }
                        }
                    );

                    const data = await response.json();

                    this.password = data.password;

                    this.revealed = true;

                    setTimeout(() => {
                        this.revealed = false;
                    }, 15000);

                } catch (error) {

                    console.error(error);

                    alert('Error al revelar contraseña');

                }

            }

        }

    }

</script>

</x-app-layout>