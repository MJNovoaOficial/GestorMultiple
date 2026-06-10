<x-app-layout>

    <div class="p-6">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold text-slate-700 dark:text-slate-200">
                    Sucursales
                </h1>

                <p class="text-slate-500 dark:text-slate-400 mt-1">
                    Gestión de sucursales del sistema
                </p>
            </div>

            <a
                href="{{ route('branches.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-lg transition"
            >
                Nueva sucursal
            </a>
        </div>

        <div class="bg-gray-950 rounded-2xl overflow-hidden shadow-lg">

            <table class="w-full">

                <thead class="bg-gray-800 text-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-center">Nombre</th>
                        <th class="px-6 py-4 text-center">Creado</th>
                        <th class="px-6 py-4 text-center">Actualizado</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>

            <tbody class="divide-y divide-gray-800">

                @forelse($branches as $branch)

                    <tr class="border-t border-gray-800 text-gray-200">

                        <td class="p-4 text-center">
                            {{ $branch->name }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $branch->created_at }}
                        </td>

                        <td class="p-4 text-center">
                            @if($branch->created_at->equalTo($branch->updated_at))
                            <span class="text-gray-500">
                                Sin actualización
                            </span>
                            @else
                                {{ $branch->updated_at }}
                            @endif
                        </td>    
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Editar --}}
                                <a
                                    href="{{ route('branches.edit', $branch) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg transition"
                                    title="Editar"
                                >
                                    ✏️
                                </a>
                                
                                {{-- Eliminar --}}
                                <form
                                    action="{{ route('branches.destroy', $branch) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Eliminar sucursal?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg transition"
                                        title="Eliminar"
                                    >
                                        🗑️
                                    </button>
                                </form>
                            </div>
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
    </div>

</x-app-layout>