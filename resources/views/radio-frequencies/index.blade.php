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
                    text-3xl font-bold text-slate-700 dark:text-slate-200
                ">
                    Radiofrecuencias
                </h1>
                <p class="
                    text-slate-500 dark:text-slate-400 mt-1
                ">
                    Listado de radiofrecuencias.
                </p>
            </div>
            <a
                href="{{ route('radio-frequencies.create') }}"
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
                Nueva Radiofrecuencia
            </a>
        </div>
        {{-- CARDS SUCURSALES --}}
        <div class="
            flex
            gap-3
            overflow-x-auto
            pb-2
            mb-6
        ">
            <a
                href="{{ route('radio-frequencies.index') }}"
                class="
                    rounded-2xl
                    border
                    border-slate-700
                    bg-slate-900
                    p-4
                    hover:border-blue-500
                    transition
                "
            >
                <div class="
                    text-slate-400
                    text-sm    
                ">
                    Todas
                </div>

                <div class="
                    text-lg
                    font-bold
                    text-white
                    text-center
                ">
                    {{ $totalRadioFrequencies }}
                </div>
            </a>

            @foreach($branches as $branch)

                <a
                    href="{{ route(
                        'radio-frequencies.index',
                        ['branch' => $branch->id]
                    ) }}"

                    class="
                        rounded-2xl
                        border
                        border-slate-700
                        bg-slate-900
                        p-4
                        hover:border-blue-500
                        transition
                    "
                >

                    <div class="
                        text-slate-400
                        text-sm
                    ">
                        {{ $branch->name }}
                    </div>

                    <div class="
                        text-lg
                        font-bold
                        text-blue-400
                        text-center
                    ">
                        {{ $branch->radio_frequencies_count }}
                    </div>

                </a>

            @endforeach

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
            {{-- Div del Search --}}
            <div class="
                p-5
                border-b
                border-slate-200
                dark:border-slate-800
            ">
                <form
                    method="GET"
                    id="search-form"
                    action="{{ route('radio-frequencies.index') }}"
                >
                    <div class="
                        flex
                        flex-col
                        lg:flex-row
                        gap-4
                    ">

                        {{-- ÁREA --}}
                        <select
                            name="area"
                            class="
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
                                min-w-[220px]
                            "
                        >
                            <option value="">
                                Todas las áreas
                            </option>

                            @foreach($areas as $area)

                                <option
                                    value="{{ $area }}"
                                    @selected(request('area') == $area)
                                >
                                    {{ $area }}
                                </option>

                            @endforeach

                        </select>

                        {{-- ESTADO --}}
                        <select
                            name="status"
                            class="
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
                                min-w-[220px]
                            "
                        >
                            <option value="">
                                Todos los estados
                            </option>

                            <option
                                value="operative"
                                @selected(request('status') == 'operative')
                            >
                                Operativa
                            </option>

                            <option
                                value="repair"
                                @selected(request('status') == 'repair')
                            >
                                Reparación
                            </option>

                            <option
                                value="retired"
                                @selected(request('status') == 'retired')
                            >
                                Dado de baja
                            </option>

                        </select>

                        {{-- BUSCADOR --}}
                        <input
                            type="text"
                            name="search"
                            id="search-input"
                            value="{{ request('search') }}"
                            placeholder="Buscar radiofrecuencias por número, SN, IP o MAC..."
                            class="
                                flex-1
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
                            "
                        >
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
                            ">Acciones</th>
                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">Número</th>
                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">Serial</th>
                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">MAC</th>
                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">IP</th>
                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">Área</th>
                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">Sucursal</th>
                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">Tipo</th>
                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">Estado</th>
                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">Observaciones</th>
                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">Bloqueada</th>
                            <th class="
                                px-6 py-4
                                text-center
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-slate-500
                                whitespace-nowrap
                            ">Garantía</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($radioFrequencies as $radio)

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
                                        data-id="{{ $radio->id }}"
                                        data-number="{{ $radio->number }}"
                                        data-serial="{{ $radio->serial }}"
                                        data-mac="{{ $radio->mac }}"
                                        data-ip="{{ $radio->ip }}"
                                        data-area="{{ $radio->area }}"
                                        data-branch_id="{{ $radio->branch_id }}"
                                        data-type="{{ $radio->type }}"
                                        data-status="{{ $radio->status }}"
                                        data-blocked="{{ $radio->blocked }}"
                                        data-warranty="{{ $radio->warranty }}"
                                        data-observations="{{ e($radio->observations) }}"
                                    >
                                        ✏️
                                    </button>
                                </div>
                            </td>

                            <td class="px-4 py-4 text-center">
                                {{ $radio->number }}
                            </td>

                            <td class="px-4 py-4 text-center">
                                {{ $radio->serial }}
                            </td>

                            <td class="px-4 py-4 text-center">
                                {{ $radio->mac }}
                            </td>

                            <td class="px-4 py-4 text-center">
                                {{ $radio->ip }}
                            </td>

                            <td class="px-4 py-4 text-center">
                                {{ $radio->area }}
                            </td>

                            <td class="px-4 py-4 text-center">
                                {{ $radio->branch->name }}
                            </td>

                            <td class="px-4 py-4 text-center">
                                {{ ucfirst($radio->type) }}
                            </td>

                            <td class="px-4 py-4 text-center">

                                @if($radio->status === 'operative')

                                    <span class="
                                        px-3 py-1
                                        rounded-full
                                        bg-green-500/20
                                        text-green-400
                                    ">
                                        Operativa
                                    </span>

                                @elseif($radio->status === 'repair')

                                    <span class="
                                        px-3 py-1
                                        rounded-full
                                        bg-yellow-500/20
                                        text-yellow-400
                                    ">
                                        Reparación
                                    </span>

                            @else

                                <span class="
                                    px-3 py-1
                                    rounded-full
                                    bg-red-500/20
                                    text-red-400
                                ">
                                    Dada de baja
                                </span>

                            @endif

                        </td>

                        <td class="px-4 py-4 text-center">
                            {{ $radio->observations ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-center">

                            @if($radio->blocked)
                                Sí
                            @else
                                No
                            @endif

                        </td>

                        <td class="px-4 py-4 text-center">

                            @if($radio->warranty)
                                Sí
                            @else
                                No
                            @endif

                        </td>
                    </tr>

                    @empty
                        <tr>
                            <td
                                colspan="12"
                                class="
                                    px-4 py-10
                                    text-center
                                    text-gray-500
                                ">
                                No hay radiofrecuencias registradas.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- PAGINACIÓN --}}
        <div class="mt-6">
            {{ $radioFrequencies->links() }}
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search-input');
        const searchForm = document.getElementById('search-form');
        let timeout = null;
        searchInput.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                searchForm.submit();
            }, 1200);
        });
    });

</script>
</x-app-layout> 