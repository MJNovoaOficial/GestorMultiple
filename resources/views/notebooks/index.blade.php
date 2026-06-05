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
                                placeholder="Buscar por nombre, RUT, marca, modelo, etc..."
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

                                <th class="px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    whitespace-nowrap">
                                    Observaciones
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
                                            data-purchase_value="{{ number_format($notebook->purchase_value, 0, ',', '.') }}"
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
                                    
                                    {{-- Serial --}}
                                    <td class="px-4 py-4 text-center">
                                        {{ $notebook->serial_number }}
                                    </td>

                                    {{-- Valor --}}
                                    <td class="px-4 py-4 text-center">
                                       <span>$</span> {{ number_format($notebook->purchase_value, 0, ',', '.') }}
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
                                    
                                    {{-- Observaciones --}}
                                    <td class="px-4 py-4 text-center">
                                        {{ $notebook->observations ?? '-' }}
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

    {{-- MODAL EDITAR NOTEBOOK --}}
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
        {{--Contenedor del Modal--}}
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
                        Editar Notebook
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

                    {{-- Usuario --}}
                    <div>

                        <label class="block mb-2 text-sm text-gray-300">
                            Nombre Usuario <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-user_name"
                            name="user_name"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                        >

                    </div>

                    {{-- RUT --}}
                    <div>

                        <label class="block mb-2 text-sm text-gray-300">
                            RUT <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-user_rut"
                            name="user_rut"
                            
                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                        >

                    </div>

                    {{-- Serial --}}
                    <div>

                        <label class="block mb-2 text-sm text-gray-300">
                            Número Serial <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-serial_number"
                            name="serial_number"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                        >

                    </div>

                    {{-- Marca --}}
                    <div>

                        <label class="block mb-2 text-sm text-gray-300">
                            Marca <span class="text-red-400">*</span>
                        </label>

                        <select
                            id="edit-brand_id"
                            name="brand_id"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                        >

                            @foreach($brands as $brand)

                                <option
                                    value="{{ $brand->id }}"
                                >
                                    {{ $brand->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Modelo --}}
                    <div>

                        <label class="block mb-2 text-sm text-gray-300">
                            Modelo <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-model"
                            name="model"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                        >

                    </div>

                    {{-- Fecha --}}
                    <div>

                        <label class="block mb-2 text-sm text-gray-300">
                            Fecha Entrega <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="date"
                            id="edit-delivery_date"
                            name="delivery_date"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                        >

                    </div>

                    {{-- Valor --}}
                    <div>
                        <label class="block text-white mb-2">
                        Valor <span class="text-red-400">*</span>
                    </label>

                    <div class="flex">

                        <span
                            class="
                                flex
                                items-center
                                justify-center

                                px-4

                                rounded-l-xl

                                border
                                border-slate-700

                                bg-slate-800

                                text-white
                            "
                        >
                            $
                        </span>

                        <input
                            type="text"
                            id="edit-purchase_value"
                            name="purchase_value"

                            class="
                                flex-1

                                rounded-r-xl

                                border
                                border-slate-700

                                bg-slate-900

                                px-4 py-3

                                text-white
                            "
                        >

                    </div>

                    </div>

                    {{-- Condición --}}
                    <div>

                        <label class="block text-white mb-2">
                            Condición <span class="text-red-400">*</span>
                        </label>

                        <select
                            id="edit-condition"
                            name="condition"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                        >
                            <option value="new">
                                Nuevo
                            </option>

                            <option value="refurbished">
                                Reacondicionado
                            </option>

                        </select>

                    </div>

                    {{-- Estado --}}
                    <div>

                        <label class="block text-white mb-2">
                            Estado <span class="text-red-400">*</span>
                        </label>

                        <select
                            id="edit-status"
                            name="status"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                        >
                            <option value="available">
                                Disponible
                            </option>

                            <option value="assigned">
                                Ocupado
                            </option>

                            <option value="retired">
                                Dado de baja
                            </option>

                        </select>

                    </div>

                    {{-- Cargo --}}
                    <div>

                        <label class="block text-white mb-2">
                            Cargo <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-position"
                            name="position"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                        >

                    </div>

                    {{-- Empresa --}}
                    <div >

                        <label class="block text-white mb-2">
                            Empresa <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-company_name"
                            name="company_name"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                        >

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

                {{-- BOTONES --}}
                <div class="
                    mt-8

                    flex
                    justify-end

                    gap-3
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

        //función que formatea el RUT a medida que se escribe, agregando puntos y guión automáticamente
        function formatRut(value) {

            let rut = value.replace(/[^0-9kK]/g, '');

            // 8 dígitos + DV
            if (rut.length > 9) {
                rut = rut.substring(0, 9);
            }

            if (rut.length <= 1) {
                return rut;
            }

            let body = rut.slice(0, -1);
            let dv = rut.slice(-1).toUpperCase();

            body = body.replace(
                /\B(?=(\d{3})+(?!\d))/g,
                '.'
            );

            return `${body}-${dv}`;
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

        //Aquí abrimos el Modal y llenamos los campos con la información del notebook seleccionado
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                const id = button.dataset.id;
                const rutInput = document.getElementById('edit-user_rut');

                if (rutInput) {

                    rutInput.addEventListener(
                        'input',
                        function () {

                            this.value = formatRut(
                                this.value
                            );

                        }
                    );

                }

                editForm.action = `/notebooks/${id}`;

                document.getElementById('edit-user_name').value =
                    button.dataset.user_name ?? '';
                document.getElementById('edit-user_rut').value =
                    formatRut(
                        button.dataset.user_rut ?? ''
                    );
                document.getElementById('edit-brand_id').value =
                    button.dataset.brand_id ?? '';
                document.getElementById('edit-model').value =
                    button.dataset.model ?? '';
                document.getElementById('edit-serial_number').value =
                    button.dataset.serial_number ?? '';
                document.getElementById('edit-purchase_value').value =
                    button.dataset.purchase_value ?? '';
                document.getElementById('edit-condition').value =
                    button.dataset.condition ?? '';
                document.getElementById('edit-status').value =
                    button.dataset.status ?? '';
                document.getElementById('edit-position').value =
                    button.dataset.position ?? '';
                document.getElementById('edit-company_name').value =
                    button.dataset.company_name ?? '';
                document.getElementById('edit-delivery_date').value =
                    button.dataset.delivery_date ?? '';
                document.getElementById('edit-observations').value =
                    button.dataset.observations ?? '';

            });

        });

        //Cerrar el Modal al hacer click en el botón de cerrar
        closeModal.addEventListener('click', () => {

        modal.classList.add('hidden');
        modal.classList.remove('flex');

    });

    </script>
    <style>
        #table-scroll::-webkit-scrollbar {

            height: 14px;

        }

        #table-scroll::-webkit-scrollbar-track {

            background: #0f172a;

        }

        #table-scroll::-webkit-scrollbar-thumb {

            background: #64748b;

            border-radius: 9999px;

        }

    </style>

</x-app-layout>