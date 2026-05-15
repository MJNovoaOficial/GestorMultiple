<x-app-layout>

    <div class="p-6">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Departamentos
                </h1>

                <p class="text-gray-400 mt-1">
                    Gestión de departamentos del sistema
                </p>
            </div>

            <a
                href="{{ route('departments.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-lg transition"
            >
                Nuevo departamento
            </a>

        </div>

        <div class="bg-gray-950 rounded-2xl overflow-hidden shadow-lg">

            <table class="w-full">

                <thead class="bg-gray-800 text-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            Nombre
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

                    @forelse($departments as $department)

                        <tr class="hover:bg-gray-900 transition">

                            <td class="px-6 py-4 text-white">
                                {{ $department->name }}
                            </td>

                            <td class="px-6 py-4 text-gray-300">
                                {{ $department->created_at->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4 text-gray-300">
                                @if($department->created_at->equalTo($department->updated_at))
                                    <span class="text-gray-500">
                                        Sin actualización
                                    </span>
                                @else
                                    {{ $department->updated_at->format('d/m/Y') }}
                                @endif
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-2">

                                    {{-- Editar --}}
                                    <a
                                        href="{{ route('departments.edit', $department) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg transition"
                                    >
                                        ✏️
                                    </a>

                                    {{-- Eliminar --}}
                                    <form
                                        action="{{ route('departments.destroy', $department) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar departamento?')"
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
                                No hay departamentos registrados.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>