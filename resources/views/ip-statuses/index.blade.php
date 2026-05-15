<x-app-layout>

    <div class="p-6">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Estados IP
                </h1>

                <p class="text-gray-400 mt-1">
                    Gestión de estados para direcciones IP
                </p>
            </div>

            <a
                href="{{ route('ip-statuses.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-lg transition"
            >
                Nuevo estado
            </a>

        </div>

        <div class="bg-gray-950 rounded-2xl overflow-hidden shadow-lg">

            <table class="w-full">

                <thead class="bg-gray-800 text-gray-200">
                    <tr>

                        <th class="px-6 py-4 text-left">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-left">
                            Color
                        </th>

                        <th class="px-6 py-4 text-left">
                            Creado
                        </th>

                        <th class="px-6 py-4 text-left">
                            Actualizado
                        </th>

                        <th class="px-6 py-4 text-left">
                            Acciones
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800">

                    @forelse($ipStatuses as $ipStatus)

                        <tr class="hover:bg-gray-900 transition">

                            {{-- Estado --}}
                            <td class="px-6 py-4">

                                <span class="{{ $ipStatus->color }} text-white px-3 py-1 rounded-full text-sm">
                                    {{ $ipStatus->name }}
                                </span>

                            </td>

                            {{-- Clase color --}}
                            <td class="px-6 py-4 text-gray-300">
                                {{ $ipStatus->color }}
                            </td>

                            {{-- Creado --}}
                            <td class="px-6 py-4 text-gray-300">
                                {{ $ipStatus->created_at->format('d/m/Y') }}
                            </td>

                            {{-- Actualizado --}}
                            <td class="px-6 py-4 text-gray-300">

                                @if($ipStatus->created_at->equalTo($ipStatus->updated_at))

                                    <span class="text-gray-500">
                                        Sin actualización
                                    </span>

                                @else

                                    {{ $ipStatus->updated_at->format('d/m/Y') }}

                                @endif

                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-2">

                                    <a
                                        href="{{ route('ip-statuses.edit', $ipStatus) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg transition"
                                    >
                                        ✏️
                                    </a>

                                    <form
                                        action="{{ route('ip-statuses.destroy', $ipStatus) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar estado?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg transition"
                                        >
                                            🗑️
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                No hay estados registrados.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>