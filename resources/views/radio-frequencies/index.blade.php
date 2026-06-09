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
                    bg-white
                    dark:bg-slate-900
                    border-slate-200
                    dark:border-slate-700
                    p-4
                    hover:border-blue-500
                    transition
                "
            >
                <div class="
                    text-slate-700
                    dark:text-slate-400 
                ">
                    Todas
                </div>

                <div class="
                    text-lg
                    font-bold
                    text-blue-600
                    dark:text-blue-400
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
                        bg-white
                        dark:bg-slate-900
                        border-slate-200
                        dark:border-slate-700
                        p-4
                        hover:border-blue-500
                        transition
                    "
                >

                    <div class="
                        text-slate-700
                        dark:text-slate-400
                    ">
                        {{ $branch->name }}
                    </div>

                    <div class="
                        text-lg
                        font-bold
                        text-blue-600
                        dark:text-blue-400
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
                    bg-slate-100
                    dark:bg-slate-900
                ">
                    <thead class="
                            bg-slate-100
                            dark:bg-slate-900
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
                            border-t
                            border-slate-200
                            dark:border-slate-800
                            hover:bg-slate-50
                            dark:hover:bg-slate-900/50
                            transition
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
                                        data-branch-id="{{ $radio->branch_id }}"
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

                            <td class="px-4 py-4 text-center
                            text-sm font-medium text-slate-900 dark:text-white">
                                {{ $radio->number }}
                            </td>

                            <td class="px-4 py-4 text-center
                            text-sm font-medium text-slate-900 dark:text-white">
                                {{ $radio->serial }}
                            </td>

                            <td class="px-4 py-4 text-center
                            text-sm font-medium text-slate-900 dark:text-white">
                                {{ $radio->mac }}
                            </td>

                            <td class="px-4 py-4 text-center
                            text-sm font-medium text-slate-900 dark:text-white">
                                {{ $radio->ip }}
                            </td>

                            <td class="px-4 py-4 text-center
                            text-sm font-medium text-slate-900 dark:text-white">
                                {{ $radio->area }}
                            </td>

                            <td class="px-4 py-4 text-center
                            text-sm font-medium text-slate-900 dark:text-white">
                                {{ $radio->branch->name }}
                            </td>

                            <td class="px-4 py-4 text-center
                            text-sm font-medium text-slate-900 dark:text-white">
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

                        <td class="px-4 py-4 text-center text-sm text-slate-700 dark:text-slate-400">
                            {{ $radio->observations ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-center text-sm
                        font-medium text-slate-900 dark:text-white">

                            @if($radio->blocked)
                                Sí
                            @else
                                No
                            @endif

                        </td>

                        <td class="px-4 py-4 text-center text-sm
                        font-medium text-slate-900 dark:text-white">

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
    {{-- MODAL EDITAR RADIOFRECUENCIA --}}
    <div
        id="edit-modal"
        class="
            hidden
            fixed
            inset-0
            z-50
            bg-black/60
            items-center
            justify-center
            p-6
        "
    >
        <div
            class="
                w-full
                max-w-5xl
                rounded-2xl
                border
                border-slate-800
                bg-[#020817]
                p-6
            "
        >

            {{-- HEADER --}}
            <div class="
                flex
                items-center
                justify-between
                mb-6
            ">
                <div>
                    <h2 class="
                        text-3xl
                        font-bold
                        text-white
                    ">
                        Editar Radiofrecuencia
                    </h2>

                    <p class="text-gray-400 mt-1">
                        Modificar información del equipo
                    </p>
                </div>

                <button
                    type="button"
                    id="close-edit-modal"
                    class="
                        text-slate-400
                        hover:text-white
                        text-xl
                        transition
                    "
                >
                    ✕
                </button>
            </div>

            <form
                id="edit-form"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="
                    grid
                    grid-cols-1
                    md:grid-cols-2
                    xl:grid-cols-3
                    gap-5
                ">

                    {{-- Número --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Número <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="number"
                            id="edit-number"
                            name="number"
                            readonly
                            class="
                                cursor-not-allowed
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-800
                                px-4 py-3
                                text-slate-400
                            "
                        >
                    </div>

                    {{-- Serial --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Serial <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-serial"
                            name="serial"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                        >
                    </div>

                    {{-- MAC --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            MAC <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-mac"
                            name="mac"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                        >
                    </div>

                    {{-- IP --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            IP <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-ip"
                            name="ip"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                        >
                    </div>

                    {{-- Área --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Área <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-area"
                            name="area"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                        >
                    </div>

                    {{-- Sucursal --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Sucursal <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="edit-branch-id"
                            name="branch_id"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                        >
                            @foreach($branches as $branch)

                                <option value="{{ $branch->id }}">
                                    {{ $branch->name }}
                                </option>

                            @endforeach
                        </select>
                    </div>

                    {{-- Tipo --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Tipo <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="edit-type"
                            name="type"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                        >
                            <option value="windows">Windows</option>
                            <option value="android">Android</option>
                            <option value="cellphone">Celular</option>
                        </select>
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Estado <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="edit-status"
                            name="status"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                        >
                            <option value="operative">Operativa</option>
                            <option value="repair">Reparación</option>
                            <option value="retired">Dado de baja</option>
                        </select>
                    </div>

                    {{-- Opciones --}}
                    <div class="flex items-center gap-6 mt-8">

                        <label class="inline-flex items-center cursor-pointer">

                            <input type="hidden" name="blocked" value="0">

                            <input
                                id="edit-blocked"
                                type="checkbox"
                                name="blocked"
                                value="1"
                                class="sr-only peer"
                            >

                            <div class="
                                relative
                                w-11 h-6
                                bg-slate-700
                                rounded-full
                                transition-colors
                                peer-checked:bg-blue-600

                                after:content-['']
                                after:absolute
                                after:top-[2px]
                                after:left-[2px]
                                after:bg-white
                                after:rounded-full
                                after:h-5
                                after:w-5
                                after:transition-all
                                peer-checked:after:translate-x-full
                            "></div>

                            <span class="ml-3 text-white">
                                Bloqueada
                            </span>

                        </label>

                        <label class="inline-flex items-center cursor-pointer">

                            <input type="hidden" name="warranty" value="0">

                            <input
                                id="edit-warranty"
                                type="checkbox"
                                name="warranty"
                                value="1"
                                class="sr-only peer"
                            >

                            <div class="
                                relative
                                w-11 h-6
                                bg-slate-700
                                rounded-full
                                transition-colors
                                peer-checked:bg-blue-600

                                after:content-['']
                                after:absolute
                                after:top-[2px]
                                after:left-[2px]
                                after:bg-white
                                after:rounded-full
                                after:h-5
                                after:w-5
                                after:transition-all
                                peer-checked:after:translate-x-full
                            "></div>

                            <span class="ml-3 text-white">
                                Posee garantía
                            </span>

                        </label>

                    </div>

                    {{-- Observaciones --}}
                    <div class="md:col-span-3">

                        <label class="block text-white mb-2">
                            Observaciones
                        </label>

                        <textarea
                            id="edit-observations"
                            name="observations"
                            rows="4"
                            class="
                                w-full
                                rounded-xl
                                border
                                border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                            "
                        ></textarea>

                    </div>

                </div>

                <div class="
                    mt-8
                    flex
                    justify-end
                ">
                    <button
                        type="submit"
                        class="
                            px-5 py-3
                            rounded-xl
                            bg-indigo-600
                            hover:bg-indigo-700
                            text-white
                            font-semibold
                        "
                    >
                        Guardar cambios
                    </button>
                </div>
            </form>
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

    const editButtons = document.querySelectorAll('.edit-device-btn');
    const modal = document.getElementById('edit-modal');
    const closeModal = document.getElementById('close-edit-modal');
    const editForm = document.getElementById('edit-form');

    editButtons.forEach(button => {

        button.addEventListener('click', () => {

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const id = button.dataset.id;

            editForm.action = `/radio-frequencies/${id}`;

            document.getElementById('edit-number').value =
                button.dataset.number ?? '';

            document.getElementById('edit-serial').value =
                button.dataset.serial ?? '';

            document.getElementById('edit-mac').value =
                button.dataset.mac ?? '';

            document.getElementById('edit-ip').value =
                button.dataset.ip ?? '';

            document.getElementById('edit-area').value =
                button.dataset.area ?? '';

            document.getElementById('edit-branch-id').value =
                button.dataset.branchId ?? '';

            document.getElementById('edit-type').value =
                button.dataset.type ?? '';

            document.getElementById('edit-status').value =
                button.dataset.status ?? '';

            document.getElementById('edit-blocked').checked =
                button.dataset.blocked == 1;

            document.getElementById('edit-warranty').checked =
                button.dataset.warranty == 1;

            document.getElementById('edit-observations').value =
                button.dataset.observations ?? '';

        });

        //cerramos el modal cuando hacemos click en la "X"
        closeModal.addEventListener('click', () => {

            modal.classList.add('hidden');
            modal.classList.remove('flex');

        });
    });

</script>
</x-app-layout> 