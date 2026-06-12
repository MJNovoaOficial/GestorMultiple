<x-app-layout>
    <div class="p-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-700 dark:text-slate-200">
                    DVRs
                </h1>

                <p class="text-slate-500 dark:text-slate-400 mt-1">
                    Listado de DVRs, NVRs e IPCs.
                </p>
            </div>

            <a
                href="{{ route('dvrs.create') }}"
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
                Nuevo DVR
            </a>
        </div>

        {{-- CARDS SUCURSALES --}}
        <div class="flex
            gap-3
            overflow-x-auto
            pb-2
            mb-6">

            <a
                href="{{ route('dvrs.index') }}"
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
                    justify-center text-center
                    dark:text-slate-400 
                    ">
                    Todas
                </div>

                <div class="
                    text-lg
                    font-bold
                    text-blue-600
                    dark:text-blue-400
                    text-center justify-center">
                    {{ $totalDvrs }}
                </div>
            </a>

            @foreach($branches as $branch)

                <a
                    href="{{ route(
                    'dvrs.index', 
                    ['branch' => $branch->id]
                    ) }}"
                    
                    class="
                        rounded-2xl
                        border
                        bg-white
                        dark:bg-slate-900
                        border-slate-200
                        dark:border-slate-700
                        p-4 justify-center text-center
                        hover:border-blue-500
                        transition
                    "
                >
                    <div class="
                        text-slate-700 justify-center text-center
                        dark:text-slate-400">
                        {{ $branch->name }}
                    </div>

                    <div class="
                        text-lg
                        font-bold
                        text-blue-600
                        dark:text-blue-400
                        text-center justify-center">
                        {{ $branch->dvrs_count }}
                    </div>

                </a>

            @endforeach

        </div>

        {{-- TABLA --}}
        <div
            class="
                overflow-hidden
                rounded-2xl
                border
                border-slate-200
                dark:border-slate-800
                bg-white
                dark:bg-[#020817]
            "
        >

            {{-- FILTROS --}}
            <div class="p-5 border-b border-slate-200 dark:border-slate-800">

                <form
                    method="GET"
                    action="{{ route('dvrs.index') }}"
                    class="flex flex-col lg:flex-row gap-4"
                >

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Buscar por nombre, modelo, SN o IP..."
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
                            font-semibold
                        "
                    >
                        Buscar
                    </button>

                </form>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-100 dark:bg-slate-900">
                        <tr>

                            <th class="px-6 py-4 text-center">
                                Acciones
                            </th>

                            <th class="px-6 py-4 text-center">
                                Nombre
                            </th>

                            <th class="px-6 py-4 text-center">
                                Sucursal
                            </th>

                            <th class="px-6 py-4 text-center">
                                Tipo
                            </th>

                            <th class="px-6 py-4 text-center">
                                Modelo
                            </th>

                            <th class="px-6 py-4 text-center">
                                MP
                            </th>

                            <th class="px-6 py-4 text-center">
                                HDD
                            </th>

                            <th class="px-6 py-4 text-center">
                                SN
                            </th>

                            <th class="px-6 py-4 text-center">
                                IP
                            </th>

                            <th class="px-6 py-4 text-center">
                                Contraseña
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @forelse($dvrs as $dvr)

                            <tr class="
                                border-t
                                border-slate-200
                                dark:border-slate-800
                                hover:bg-slate-50
                                dark:hover:bg-slate-900/50
                                transition
                            ">

                                <td class="px-4 py-4 
                                    whitespace-nowrap text-center">

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
                                            data-id="{{ $dvr->id }}"
                                            data-nombre="{{ $dvr->nombre }}"
                                            data-branch-id="{{ $dvr->branch_id }}"
                                            data-tipo="{{ $dvr->tipo }}"
                                            data-modelo="{{ $dvr->modelo }}"
                                            data-mp="{{ $dvr->mp }}"
                                            data-hdd="{{ $dvr->hdd }}"
                                            data-sn="{{ $dvr->sn }}"
                                            data-ip="{{ $dvr->ip }}"
                                            data-password="{{ $dvr->password }}"
                                        >
                                            ✏️
                                        </button>

                                        <form
                                            action="{{ route('dvrs.retire', $dvr) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Desea borrar este DVR?')"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="
                                                    inline-flex
                                                    items-center
                                                    justify-center
                                                    w-10 h-10
                                                    rounded-xl
                                                    bg-red-500
                                                    hover:bg-red-600
                                                    text-white
                                                "
                                            >
                                                🗑️
                                            </button>

                                        </form>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-center">
                                    {{ $dvr->nombre }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    {{ $dvr->branch->name }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    {{ $dvr->tipo }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    {{ $dvr->modelo }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    {{ $dvr->mp }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    {{ $dvr->hdd }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    {{ $dvr->sn }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    {{ $dvr->ip }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <div
                                        x-data="passwordReveal({{ $dvr->id }})"
                                        class="flex items-center gap-3 inline-flex"
                                    >

                                        <span x-text="revealed ? password : '••••••••••••••'"></span>

                                        <button
                                            type="button"
                                            @click="toggleReveal()"
                                            class="text-gray-400 hover:text-white transition"
                                        >

                                            <span x-show="!revealed">

                                                {{-- Ojo abierto --}}
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="w-5 h-5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5
                                                        c4.478 0 8.268 2.943 9.542 7
                                                        -1.274 4.057-5.064 7-9.542 7
                                                        -4.477 0-8.268-2.943-9.542-7z"
                                                    />
                                                </svg>

                                            </span>

                                            <span x-show="revealed">

                                                {{-- Ojo tachado --}}
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="w-5 h-5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19
                                                        c-4.478 0-8.268-2.943-9.542-7
                                                        a9.956 9.956 0 012.293-3.95m3.123-2.342
                                                        A9.953 9.953 0 0112 5c4.478 0 8.268 2.943
                                                        9.542 7a9.97 9.97 0 01-4.293 5.774
                                                        M15 12a3 3 0 00-4.878-2.121
                                                        M3 3l18 18"
                                                    />
                                                </svg>

                                            </span>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td
                                    colspan="10"
                                    class="px-6 py-8 text-center text-slate-500"
                                >
                                    No hay DVRs registrados.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
        {{-- paginación --}}
        <div class="mt-6">
            {{ $dvrs->links() }}
        </div>
    </div>
    {{-- Modal Edición de DVRs --}}
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
            {{-- Header --}}
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
                        Editar DVR
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
                    {{-- nombre --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Nombre <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-nombre"
                            name="nombre"
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
                            id="edit-tipo"
                            name="tipo"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                        >
                            <option value="DVR">DVR</option>
                            <option value="NVR">NVR</option>
                            <option value="IPC">IPC</option>
                        </select>
                    </div>

                    {{-- Modelo --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            modelo <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-modelo"
                            name="modelo"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                        >
                    </div>

                    {{-- MP --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            MP <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="edit-mp"
                            name="mp"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                        >
                            <option value="1MP">1MP</option>
                            <option value="2MP">2MP</option>
                            <option value="4MP">4MP</option>
                            <option value="5MP">5MP</option>
                            <option value="8MP">8MP</option>
                        </select>
                    </div>

                    {{-- Disco capacidad --}}

                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            HDD <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="edit-hdd"
                            name="hdd"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                        >
                            <option value="128GB">128 GB</option>
                            <option value="256GB">256 GB</option>
                            <option value="1TB">1 TB</option>
                            <option value="2TB">2 TB</option>
                            <option value="4TB">4 TB</option>
                            <option value="6TB">6 TB</option>
                            <option value="8TB">8 TB</option>
                        </select>
                    </div>

                    {{-- Número Serial --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Número Serial <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-sn"
                            name="sn"
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

                    {{-- contraseña --}}
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Contraseña <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-password"
                            name="password"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-white"
                        >
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
        </div>
            
    </div>

    <script>
        window.passwordStore = {};

        function passwordReveal(id) {
            return {
                revealed: false,
                password: '',

                async toggleReveal() {

                    if (!this.revealed && !this.password) {

                        const response = await fetch(`/dvrs/${id}/password`);

                        const data = await response.json();

                        this.password = data.password;
                    }

                    this.revealed = !this.revealed;
                }
            }
        }

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

                editForm.action = `/dvrs/${id}`;

                document.getElementById('edit-nombre').value =
                    button.dataset.nombre ?? '';

                document.getElementById('edit-branch-id').value =
                    button.dataset.branchId ?? '';

                document.getElementById('edit-tipo').value =
                    button.dataset.tipo ?? '';

                document.getElementById('edit-modelo').value =
                    button.dataset.modelo ?? '';

                document.getElementById('edit-mp').value =
                    button.dataset.mp ?? '';

                document.getElementById('edit-sn').value =
                    button.dataset.sn ?? '';

                document.getElementById('edit-ip').value =
                    button.dataset.ip ?? '';

                document.getElementById('edit-password').value =
                    button.dataset.password ?? '';
            });

            //cerramos el modal cuando hacemos click en la "X"
            closeModal.addEventListener('click', () => {

                modal.classList.add('hidden');
                modal.classList.remove('flex');

            });
        });
    </script>
</x-app-layout>