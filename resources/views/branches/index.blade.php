<x-app-layout>

    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-3xl font-bold text-white">
                Sucursales
            </h1>

            <p class="text-gray-400">
                Gestión de sucursales del sistema
            </p>
        </div>

        <a href="{{ route('branches.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
            Nueva sucursal
        </a>

    </div>

    <div class="bg-gray-900 rounded-xl shadow overflow-hidden">

        <table class="w-full text-left">

            <thead class="bg-gray-800 text-gray-300">

                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Nombre</th>
                    <th class="p-4">Ciudad</th>
                    <th class="p-4">Creado</th>
                    <th class="p-4">Acciones</th>
                </tr>

            </thead>

            <tbody>

                @forelse($branches as $branch)

                    <tr class="border-t border-gray-800 text-gray-200">

                        <td class="p-4">
                            {{ $branch->id }}
                        </td>

                        <td class="p-4">
                            {{ $branch->name }}
                        </td>

                        <td class="p-4">
                            {{ $branch->city }}
                        </td>

                        <td class="p-4">
                            {{ $branch->created_at->format('d/m/Y') }}
                        </td>

                        <td class="p-4">

                            <a href="{{ route('branches.edit', $branch) }}"
                               class="text-indigo-400 hover:text-indigo-300">
                                Editar
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="p-6 text-center text-gray-500">

                            No hay sucursales registradas.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</x-app-layout>