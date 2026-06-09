<x-app-layout>

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">

            <div>

                <h1 class="
                    text-3xl font-bold
                    text-slate-900 dark:text-white
                ">
                    Gestión de Suministros
                </h1>

                <p class="
                    mt-2
                    text-slate-600 dark:text-slate-400
                ">
                    Administra inventario y stock de
                    suministros de impresoras.
                </p>

            </div>

            <a
                href="{{ route('supplies.create') }}"
                class="
                    inline-flex items-center
                    px-5 py-3
                    rounded-xl
                    bg-blue-600 hover:bg-blue-700
                    text-white font-semibold
                    transition
                "
            >
                Registrar
            </a>

        </div>

        {{-- Search --}}
        <div class="
            bg-white dark:bg-[#111827]
            border border-slate-200 dark:border-slate-800
            rounded-2xl
            p-5
        ">

            <input
                type="text"
                id="globalSearch"
                placeholder="Buscar marca, modelo o suministro..."
                class="
                    w-full px-4 py-3
                    border-slate-300
                    dark:border-slate-700
                    bg-white
                    dark:bg-slate-900
                    text-sm
                    text-slate-900
                    dark:text-white
                    rounded-2xl
                    focus:ring-2 focus:ring-blue-500
                    focus:outline-none
                "
            >

        </div>

        {{-- Table + Modal --}}
        <div
            x-data="{
                showModal: false,
                modalType: '',
                modalAction: '',
                modalTitle: '',
            }"
        >

            {{-- Table --}}
            <div class="
                overflow-x-auto
                border
                border-slate-200
                dark:border-slate-800
                overflow-y-auto
                max-h-[70vh]
            ">

                <table class="w-full
                    text-sm
                    text-left
                    text-gray-300
                    bg-slate-100
                    dark:bg-slate-900">

                    {{-- Header --}}
                    <thead class="bg-slate-100
                            dark:bg-slate-900">

                        <tr>

                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">
                                Marca Impresora
                            </th>

                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">
                                Modelo de impresora
                            </th>

                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">
                                Modelo de Tóner
                            </th>

                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">
                                Cantidad
                            </th>

                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">
                                Estado
                            </th>

                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">
                                Última modificación
                            </th>

                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    {{-- Body --}}
                    <tbody class="divide-y divide-gray-800">

                        @forelse($supplies as $supply)

                            @php

                                $statusColor =
                                    $supply->quantity <= 0
                                        ? 'bg-red-500'
                                        : (
                                            $supply->quantity <=
                                            $supply->minimum_stock
                                                ? 'bg-yellow-500'
                                                : 'bg-green-500'
                                        );

                                $statusLabel =
                                    $supply->quantity <= 0
                                        ? 'Sin stock'
                                        : (
                                            $supply->quantity <=
                                            $supply->minimum_stock
                                                ? 'Stock bajo'
                                                : 'Disponible'
                                        );

                            @endphp

                            <tr class="
                                user-row
                                border-t
                                border-slate-200
                                dark:border-slate-800
                                hover:bg-slate-50
                                dark:hover:bg-slate-900/50
                                transition
                            ">

                                <td class="
                                    px-6 py-4 text-center
                                    text-sm font-medium text-slate-900 dark:text-white
                                ">
                                    {{ $supply->brand }}
                                </td>

                                <td class="
                                    px-6 py-4 text-center
                                    text-sm font-medium text-slate-900 dark:text-white
                                ">
                                    {{ $supply->printer_model }}
                                </td>

                                <td class="
                                    px-6 py-4 text-center
                                    text-sm font-medium text-slate-900 dark:text-white
                                ">
                                    {{ $supply->supply_type }}
                                </td>

                                <td class="
                                    px-6 py-4 text-center
                                    text-sm font-medium text-slate-900 dark:text-white
                                ">
                                    {{ $supply->quantity }}
                                </td>

                                <td class="
                                    px-6 py-4 text-center
                                    text-sm font-medium text-slate-900 dark:text-white
                                ">

                                    <span class="
                                        inline-flex items-center
                                        px-3 py-1
                                        rounded-full
                                        text-xs font-semibold
                                        text-white
                                        {{ $statusColor }}
                                    ">
                                        {{ $statusLabel }}
                                    </span>

                                </td>

                                <td class="
                                    px-6 py-4 text-center
                                    text-sm font-medium text-slate-900 dark:text-white
                                ">
                                    {{ $supply->updated_at->diffForHumans() }}
                                </td>

                                {{-- Actions --}}
                                <td class="
                                    px-6 py-4 text-center
                                    text-sm font-medium text-slate-900 dark:text-white
                                ">

                                    <div class="
                                        flex items-center
                                        justify-center
                                        gap-2
                                    ">

                                        {{-- AGREGAR --}}
                                        <button
                                            @click="
                                                showModal = true;
                                                modalType = 'add';
                                                modalTitle = 'Agregar stock';
                                                modalAction = '{{ route('supplies.add', $supply) }}';
                                            "
                                            class="
                                                w-11 h-11
                                                rounded-xl
                                                flex items-center justify-center
                                                bg-green-600 hover:bg-green-700
                                                text-white text-base font-bold
                                                shadow-md
                                                transition
                                            "
                                        >
                                            ⬆
                                        </button>

                                        {{-- DESCONTAR --}}
                                        <button
                                            @click="
                                                showModal = true;
                                                modalType = 'remove';
                                                modalTitle = 'Descontar stock';
                                                modalAction = '{{ route('supplies.remove', $supply) }}';
                                            "
                                            class="
                                                w-11 h-11
                                                rounded-xl
                                                flex items-center justify-center
                                                bg-red-600 hover:bg-red-700
                                                text-white text-base font-bold
                                                shadow-md
                                                transition
                                            "
                                        >
                                            ⬇
                                        </button>

                                        {{-- ELIMINAR --}}
                                        <form
                                            action="{{ route('supplies.destroy', $supply) }}"
                                            method="POST"
                                            onsubmit="
                                                return confirm(
                                                    '¿Eliminar suministro?'
                                                )
                                            "
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="
                                                    w-12 h-11
                                                    rounded-xl
                                                    flex items-center justify-center
                                                    bg-slate-700 hover:bg-slate-800
                                                    text-white text-base
                                                    shadow-md
                                                    transition
                                                "
                                            >
                                                🗑
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="
                                        px-6 py-10
                                        text-center
                                        text-slate-500 dark:text-slate-400
                                    "
                                >

                                    No hay suministros registrados.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Modal --}}
            <div
                x-show="showModal"
                x-cloak
                class="
                    fixed inset-0 z-50
                    flex items-center justify-center
                    bg-black/60
                "
            >

                <div
                    @click.away="showModal = false"
                    class="
                        max-w-lg
                        rounded-2xl
                        bg-white dark:bg-[#111827]
                        border border-slate-200 dark:border-slate-800
                        p-6
                    "
                >

                    <h2 class="
                        text-xl font-bold
                        text-slate-900 dark:text-white
                    "
                        x-text="modalTitle"
                    ></h2>

                    <form
                        :action="modalAction"
                        method="POST"
                        class="mt-6 space-y-5"
                    >

                        @csrf

                        <div>

                            <label class="
                                block mb-2
                                text-sm font-semibold
                                text-slate-700 dark:text-slate-300
                            ">
                                Cantidad
                            </label>

                            <input
                                type="number"
                                name="quantity"
                                min="1"
                                value="1"
                                required
                                class="
                                    w-full rounded-xl
                                    border-slate-300 dark:border-slate-700
                                    dark:bg-slate-800
                                    dark:text-white
                                "
                            >

                        </div>

                        <div class="
                            flex justify-end gap-3
                        ">

                            <button
                                type="button"
                                @click="showModal = false"
                                class="
                                    px-4 py-2
                                    rounded-xl
                                    border border-slate-300 dark:border-slate-700
                                    text-slate-700 dark:text-slate-300
                                "
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="
                                    px-5 py-2
                                    rounded-xl
                                    text-white font-semibold
                                "
                                :class="
                                    modalType === 'add'
                                        ? 'bg-green-600 hover:bg-green-700'
                                        : 'bg-red-600 hover:bg-red-700'
                                "
                            >
                                Confirmar
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        {{-- Pagination --}}
        <div>
            {{ $supplies->links() }}
        </div>

    </div>
    <script>

        const globalSearch =
            document.getElementById(
                'globalSearch'
            );

        globalSearch.addEventListener(
            'input',
            () => {

                const value =
                    globalSearch.value
                        .toLowerCase();

                document
                    .querySelectorAll('.user-row')
                    .forEach(row => {

                        const content =
                            row.innerText
                                .toLowerCase();

                        row.style.display =
                            content.includes(value)
                                ? ''
                                : 'none';

                    });

            }
        );

    </script>

</x-app-layout>