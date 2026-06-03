<x-app-layout>

    <div class="p-6">

        {{-- HEADER --}}
        <div class="
            flex
            items-center
            justify-between

            mb-6
        ">

            <div>

                <h1 class="
                    text-3xl
                    font-bold
                    text-white
                ">
                    Notebooks
                </h1>

                <p class="text-gray-400 mt-1">
                    Gestión de notebooks corporativos
                </p>

            </div>

            <a
                href="{{ route('notebooks.create') }}"

                class="
                    px-5 py-3

                    rounded-2xl

                    bg-green-600
                    hover:bg-green-700

                    transition

                    text-white
                    font-semibold
                "
            >
                Nuevo Notebook
            </a>

        </div>

        {{-- TABLA --}}
        <div class="
            overflow-x-auto
                overflow-y-visible
                rounded-2xl
                border
                border-slate-200
                dark:border-slate-800
                bg-white
                dark:bg-[#020817]
        ">

            {{-- SEARCH --}}
                <div class="
                    p-5
                    border-b
                    border-slate-200
                    dark:border-slate-800
                ">
                    <form method="GET"
                        id=search-form
                        action="{{ route('notebooks.index') }}"
                    >
                        <div class="
                            flex
                            flex-col
                            lg:flex-row
                            gap-4
                        ">
                            <input
                                type="text"
                                name="search"
                                id="search-input"   
                                value="{{ request('search') }}"
                                placeholder="Buscar por nombre, IMEI, correo o RUT..."
                                class="
                                    w-full
                                    rounded-xl
                                    border
                                    border-slate-300
                                    dark:border-slate-700
                                    bg-white
                                    dark:bg-slate-900
                                    px-4 py-3
                                    text-sm
                                    text-slate-900
                                    dark:text-white
                                "
                            >
                            <button
                                type="submit"

                                class="
                                    px-5 py-3

                                    rounded-xl

                                    bg-blue-600
                                    hover:bg-blue-700

                                    text-white
                                    text-sm
                                    font-semibold

                                    transition
                                ">
                                Buscar
                            </button>
                        </div>
                    </form>
                </div>
                <div
                    id="table-scroll"

                    class="
                        overflow-x-auto
                        overflow-y-auto
                        max-h-[70vh]
                    "
                >

                    <table class="
                        w-full

                        text-sm

                        text-left

                        text-gray-300
                    ">

                        <thead class="
                            bg-slate-900

                            text-gray-400
                        ">

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
                                    Acciones
                                </th>

                                <th class="px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    whitespace-nowrap">
                                    Nombre
                                </th>

                                <th class="px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    whitespace-nowrap">
                                    RUT
                                </th>

                                <th class="px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    whitespace-nowrap">
                                    Marca
                                </th>

                                <th class="px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    whitespace-nowrap">
                                    Modelo
                                </th>

                                <th class="px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    whitespace-nowrap">
                                    Serial
                                </th>

                                <th class="px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    whitespace-nowrap">
                                    Valor
                                </th>

                                <th class="px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    whitespace-nowrap">
                                    Estado
                                </th>

                                <th class="px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    whitespace-nowrap">
                                    Condición
                                </th>

                                <th class="px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    whitespace-nowrap">
                                    Empresa
                                </th>

                                <th class="px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    whitespace-nowrap">
                                    Cargo
                                </th>

                                <th class="px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    whitespace-nowrap">
                                    Entrega
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($notebooks as $notebook)

                                <tr class="
                                    border-t border-slate-800

                                    hover:bg-slate-900/50
                                ">
                                     <td class="
                                    px-6 py-4
                                    whitespace-nowrap
                                ">

                                    <div class="
                                        flex
                                        items-center
                                        justify-center
                                        gap-2
                                    ">

                                        <button
                                            type="button"
                                            class="
                                                edit-device-btn
                                                inline-flex
                                                items-center
                                                justify-center
                                                w-10 h-10
                                                rounded-xl
                                                bg-blue-500
                                                hover:bg-blue-600
                                                text-white
                                                transition
                                            "

                                            data-id="{{ $notebook->id }}"
                                            data-user_name="{{ $notebook->user_name }}"
                                            data-user_rut="{{ $notebook->user_rut }}"
                                            data-serial_number="{{ $notebook->serial_number }}"
                                            data-model="{{ $notebook->model }}"
                                            data-brand_id="{{ $notebook->brand_id }}"
                                            data-delivery_date="{{ $notebook->delivery_date }}"
                                            data-purchase_value="{{ $notebook->purchase_value }}"
                                            data-condition="{{ $notebook->condition }}"
                                            data-status="{{ $notebook->status }}"
                                            data-position="{{ $notebook->position }}"
                                            data-company_name="{{ $notebook->company_name }}"
                                            data-observations="{{ e($notebook->observations) }}"
                                            
                                        >
                                            ✏️
                                        </button>
                                    </div>
                                </td>

                                    {{-- Usuario --}}
                                    <td class="px-4 py-4 text-center">
                                    @if($notebook->status === 'available')
                                        Libre
                                    @elseif($notebook->status === 'retired')
                                        Dado de baja
                                    @else
                                        {{ $notebook->user_name }}
                                    @endif
                                    </td>

                                    {{-- RUT --}}
                                    <td class="px-4 py-4 text-center">                                    
                                    @if($notebook->status === 'available')
                                        Libre
                                    @elseif($notebook->status === 'retired')
                                        Dado de baja
                                    @else
                                        {{ $notebook->user_rut }}
                                    @endif
                                    </td>

                                    {{-- Marca --}}
                                    <td class="px-4 py-4 text-center">
                                        {{ $notebook->brand->name }}
                                    </td>

                                    {{-- Modelo --}}
                                    <td class="px-4 py-4 text-center">
                                        {{ $notebook->model }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        {{ number_format($notebook->purchase_value, 0, ',', '.') }}
                                    </td>

                                    {{-- Serial --}}
                                    <td class="px-4 py-4 text-center">
                                        {{ $notebook->serial_number }}
                                    </td>

                                    {{-- Estado --}}
                                    <td class="px-4 py-4 text-center">

                                        @if($notebook->status === 'available')

                                            <span class="
                                                px-3 py-1

                                                rounded-full

                                                bg-green-500/20

                                                text-green-400
                                            ">
                                                Disponible
                                            </span>

                                        @elseif($notebook->status === 'assigned')

                                            <span class="
                                                px-3 py-1

                                                rounded-full

                                                bg-blue-500/20

                                                text-blue-400
                                            ">
                                                Ocupado
                                            </span>

                                        @else

                                            <span class="
                                                px-3 py-1

                                                rounded-full

                                                bg-red-500/20

                                                text-red-400
                                            ">
                                                Dado de baja
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Condición --}}
                                    <td class="px-4 py-4 text-center">

                                        @if($notebook->condition === 'new')

                                            Nuevo

                                        @else

                                            Reacondicionado

                                        @endif

                                    </td>

                                    {{-- Empresa --}}
                                    <td class="px-4 py-4 text-center">
                                        @if($notebook->status === 'available')
                                            Libre
                                        @elseif($notebook->status === 'retired')
                                            Dado de baja
                                        @else
                                            {{ $notebook->company_name }}
                                        @endif
                                    </td>
                                    
                                    {{-- Cargo --}}
                                    <td class="px-4 py-4 text-center">
                                        @if($notebook->status === 'available')
                                            Libre
                                        @elseif($notebook->status === 'retired')
                                            Dado de baja
                                        @else
                                            {{ $notebook->position }}
                                        @endif
                                    </td>

                                    {{-- Fecha --}}
                                    <td class="px-4 py-4 text-center">
                                        @if($notebook->status === 'available')
                                            Libre
                                        @elseif($notebook->status === 'retired')
                                            Dado de baja
                                        @else
                                            {{ \Carbon\Carbon::parse($notebook->delivery_date)->format('d/m/Y') }}
                                        @endif
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="9"

                                        class="
                                            px-4 py-10

                                            text-center

                                            text-gray-500
                                        "
                                    >
                                        No hay notebooks registrados.
                                    </td>

                                </tr>

                            @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINACIÓN --}}
        <div class="mt-6">

            {{ $notebooks->links() }}

        </div>

    </div>

</x-app-layout>