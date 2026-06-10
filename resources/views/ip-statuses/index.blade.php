<x-app-layout>

    <div class="p-6">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold text-slate-700 dark:text-slate-200">
                    Estados IP
                </h1>

                <p class="text-slate-500 dark:text-slate-400 mt-1">
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
            
            @php
                $colors = [
                'green' => 'bg-green-500',
                'blue' => 'bg-blue-500',
                'yellow' => 'bg-yellow-500',
                'red' => 'bg-red-500',
                'orange' => 'bg-orange-500',
                ];
            @endphp

            <table class="w-full">

                <thead class="bg-gray-800 text-gray-200">
                    <tr>

                        <th class="px-6 py-4 text-center">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-center">
                            Creado
                        </th>

                        <th class="px-6 py-4 text-center">
                            Actualizado
                        </th>

                        <th class="px-6 py-4 text-center">
                            Acciones
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800">

                    @forelse($ipStatuses as $ipStatus)

                        <tr class="hover:bg-gray-900 transition">

                            {{-- Estado --}}
                            <td class="px-6 py-4 text-center">

                                <span class="{{ $colors[$ipStatus->color] ?? 'bg-gray-500' }} text-white px-3 py-1 rounded-full text-sm">
                                    {{ $ipStatus->name }}
                                </span>

                            </td>

                            {{-- Creado --}}
                            <td class="px-6 py-4 text-gray-300 text-center">
                                {{ $ipStatus->created_at
                            </td>

                            {{-- Actualizado --}}
                            <td class="px-6 py-4 text-gray-300 text-center">

                                @if($ipStatus->created_at->equalTo($ipStatus->updated_at))

                                    <span class="text-gray-500">
                                        Sin actualización
                                    </span>

                                @else

                                    {{ $ipStatus->updated_at }}

                                @endif

                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4 text-center">

                                <div class="flex items-center justify-center gap-2">

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