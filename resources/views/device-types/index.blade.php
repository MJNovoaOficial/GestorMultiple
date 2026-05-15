<x-app-layout>

    <div class="p-6">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Tipos de dispositivo
                </h1>

                <p class="text-gray-400 mt-1">
                    Gestión de tipos de dispositivo del sistema
                </p>
            </div>

            <a
                href="{{ route('device-types.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-lg transition"
            >
                Nuevo tipo de dispositivo
            </a>

        </div>

        <div class="bg-gray-950 rounded-2xl overflow-hidden shadow-lg">

            <table class="w-full">

                <thead class="bg-gray-800 text-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-center">
                            Nombre
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

                    @forelse($deviceTypes as $deviceType)

                        <tr class="hover:bg-gray-900 transition">

                            <td class="px-6 py-4 text-white text-center">
                                {{ $deviceType->name }}
                            </td>

                            <td class="px-6 py-4 text-gray-300 text-center">
                                {{ $deviceType->created_at->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4 text-gray-300 text-center">
                                @if($deviceType->created_at->equalTo($deviceType->updated_at))
                                    <span class="text-gray-500">
                                        Sin actualización
                                    </span>
                                @else
                                    {{ $deviceType->updated_at->format('d/m/Y') }}
                                @endif
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- Editar --}}
                                    <a
                                        href="{{ route('device-types.edit', $deviceType) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg transition"
                                    >
                                        ✏️
                                    </a>

                                    {{-- Eliminar --}}
                                    <form
                                        action="{{ route('device-types.destroy', $deviceType) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar tipo de dispositivo?')"
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
                            <td colspan="4" class="px-6 py-6 text-center text-gray-500">
                                No hay tipos de dispositivos registrados.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>