<x-app-layout>

<div class="p-6">

    {{-- Header --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-slate-700 dark:text-slate-200">
            Auditoría
        </h1>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Registro de acciones realizadas en MultiGestor
        </p>

    </div>

    {{-- Tabla --}}
    <div class="overflow-hidden bg-gray-900 border border-gray-800 rounded-2xl">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-800">

                {{-- Header --}}
                <thead class="bg-[#0F172A]">

                    <tr>

                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-400 uppercase">
                            Usuario
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-400 uppercase">
                            Acción
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-400 uppercase">
                            Descripción
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-400 uppercase">
                            IP
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-400 uppercase">
                            Fecha
                        </th>

                    </tr>

                </thead>

                {{-- Body --}}
                <tbody class="divide-y divide-gray-800">

                    @forelse($audits as $audit)

                        <tr class="hover:bg-gray-800/40 transition">

                            {{-- Usuario --}}
                            <td class="px-6 py-4 text-sm text-white">

                                {{ $audit->user?->name ?? 'Sistema' }}

                            </td>

                            {{-- Acción --}}
                            <td class="px-6 py-4">

                                @php

                                    $colors = [
                                        'created' => 'bg-green-600',
                                        'updated' => 'bg-blue-600',
                                        'regenerated' => 'bg-yellow-500',
                                        'revealed' => 'bg-purple-600',
                                        'deleted' => 'bg-red-600',
                                    ];
                                    
                                    $labels = [
                                        'created' => 'CREADO',
                                        'updated' => 'ACTUALIZADO',
                                        'regenerated' => 'REGENERADO',
                                        'revealed' => 'REVELADO',
                                        'deleted' => 'ELIMINADO',
                                    ];
                                @endphp

                                <span class="
                                    px-3 py-1 rounded-full text-xs font-semibold text-white
                                    {{ $colors[$audit->action] ?? 'bg-gray-600' }}
                                ">

                                    {{ $labels[$audit->action] ?? strtoupper($audit->action) }}

                                </span>

                            </td>

                            {{-- Descripción --}}
                            <td class="px-6 py-4 text-sm text-gray-300">

                                {{ $audit->description }}

                            </td>

                            {{-- IP --}}
                            <td class="px-6 py-4 text-sm text-gray-400">

                                {{ $audit->ip_address }}

                            </td>

                            {{-- Fecha --}}
                            <td class="px-6 py-4 text-sm text-gray-400">

                                {{ $audit->created_at->format('d/m/Y H:i') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-8 text-sm text-center text-gray-500"
                            >

                                No existen registros de auditoría.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Paginación --}}
    <div class="mt-6">

        {{ $audits->links() }}

    </div>

</div>

</x-app-layout>