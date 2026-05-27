<x-app-layout>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
    >
    <div class="w-full max-w-[2400px] mx-auto px-4 sm:px-6 lg:px-8 mt-4 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="
                    text-3xl font-bold text-slate-700 dark:text-slate-200
                ">
                    Celulares Corporativos
                </h1>
                <p class="
                    text-slate-500 dark:text-slate-400 mt-1
                ">
                    Gestión de dispositivos móviles entregados
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">

                {{-- IMPORTAR EXCEL --}}

                <form
                    id="excel-import-form"
                    action="{{ route('employee-phones.import') }}"
                    method="POST"
                    enctype="multipart/form-data"

                    class="flex items-center gap-3"
                >
                    @csrf

                    <input
                        type="file"
                        id="excel-file-input"
                        name="file"
                        accept=".xlsx,.xls"
                        class="hidden"
                    >
                    <button
                        type="button"
                        id="import-button"

                        class="
                            inline-flex
                            items-center
                            gap-2

                            px-4 py-2.5

                            rounded-xl

                            bg-emerald-600
                            hover:bg-emerald-700

                            text-white
                            text-sm
                            font-semibold

                            transition
                        "
                    >
                        <span id="import-button-text">
                            Importar Excel
                        </span>
                    </button>

                </form>

                {{-- NUEVO REGISTRO --}}

                <a
                    href="{{ route('employee-phones.create') }}"

                    class="
                        inline-flex
                        items-center
                        gap-2

                        px-4 py-2.5

                        rounded-xl

                        bg-indigo-600
                        hover:bg-indigo-700

                        text-white
                        text-sm
                        font-semibold

                        transition
                    "
                >
                    Nuevo Registro
                </a>

            </div>
        </div>
    </div>
    
    @if(session('success'))
        <div class="
            mb-4
            rounded-xl
            bg-emerald-500/10
            border border-emerald-500/20
            text-emerald-300
            px-4 py-3
        ">

            {{ session('success') }}

        </div>
    @endif

    <div class="pb-8">
        <div class="w-full max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
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
                        action="{{ route('employee-phones.index') }}"
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
                {{-- TABLE --}}
                <div
                    id="table-scroll"

                    class="
                        overflow-x-auto
                        overflow-y-auto
                        max-h-[70vh]
                    "
                >
                    <table
                        class="min-w-[3200px]"
                    >
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
                                ">
                                    Acciones
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-left
                                    whitespace-nowrap
                                    text-xs
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500">
                                    Número
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    whitespace-nowrap
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                    ">
                                    Nombre
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    whitespace-nowrap
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                ">
                                    Modelo
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    uppercase
                                    whitespace-nowrap
                                    tracking-wider
                                    text-slate-500
                                ">
                                    Fecha Entrega
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    whitespace-nowrap
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                ">
                                    IMEI
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    whitespace-nowrap
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                ">
                                    Cargo
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    whitespace-nowrap
                                    font-bold
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                ">
                                    Área
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    whitespace-nowrap
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                ">
                                    Código Vendedor
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    whitespace-nowrap
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                ">
                                    Empresa
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    whitespace-nowrap
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                ">
                                    Rut
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    whitespace-nowrap
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                ">
                                    Correo
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-left
                                    text-xs
                                    font-bold
                                    whitespace-nowrap
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                ">
                                    Observaciones
                                </th>
                                <th class="
                                    px-6 py-4
                                    text-center
                                    text-xs
                                    font-bold
                                    whitespace-nowrap
                                    uppercase
                                    tracking-wider
                                    text-slate-500
                                ">
                                    Estado
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($devices as $device)
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

                                            data-id="{{ $device->id }}"
                                            data-phone_number="{{ $device->phone_number }}"
                                            data-first_name="{{ $device->first_name }}"
                                            data-last_name="{{ $device->last_name }}"
                                            data-phone_model="{{ $device->phone_model }}"
                                            data-delivery_date="{{ $device->delivery_date }}"
                                            data-imei="{{ $device->imei }}"
                                            data-position="{{ $device->position }}"
                                            data-department="{{ $device->department }}"
                                            data-vendor_code="{{ $device->vendor_code }}"
                                            data-company_name="{{ $device->company_name }}"
                                            data-rut="{{ $device->rut }}"
                                            data-email="{{ $device->email }}"
                                            data-observations="{{ $device->observations }}"
                                            data-status="{{ $device->status }}"
                                        >
                                            ✏️
                                        </button>
                                    </div>
                                </td>

                                <td class="
                                    whitespace-nowrap
                                    px-6 py-4
                                    text-sm
                                    font-medium
                                    text-slate-900
                                    dark:text-white
                                ">
                                    {{ preg_replace('/^\+56/', '', $device->phone_number) }}
                                </td>
                                    
                                <td class="
                                    whitespace-nowrap
                                    px-6 py-4
                                    text-sm
                                    font-medium
                                    text-slate-900
                                    dark:text-white
                                ">
                                    {{ $device->first_name }}
                                    {{ $device->last_name }}
                                </td>

                                <td class="
                                    whitespace-nowrap
                                    px-6 py-4
                                    text-sm
                                    text-slate-700
                                    dark:text-slate-300
                                ">
                                    {{ $device->phone_model }}
                                </td>
                                    
                                <td class="
                                    whitespace-nowrap
                                    px-6 py-4
                                    text-sm
                                    text-slate-700
                                    dark:text-slate-300
                                ">
                                    {{ $device->delivery_date->format('d/m/Y') }}
                                </td>
                                    
                                <td class="
                                    whitespace-nowrap
                                    px-6 py-4
                                    text-sm
                                    text-slate-700
                                    dark:text-slate-300
                                ">
                                    {{ $device->imei}}
                                </td>

                                <td class="
                                    whitespace-nowrap
                                    px-6 py-4
                                    text-sm
                                    text-slate-700
                                    dark:text-slate-300
                                ">
                                    {{ $device->position ?? '—' }}
                                </td>

                                <td class="
                                    whitespace-nowrap
                                    px-6 py-4
                                    text-sm
                                    text-slate-700
                                    dark:text-slate-300
                                ">
                                    {{ $device->department ?? '—' }}
                                </td>

                                <td class="
                                    whitespace-nowrap
                                    px-6 py-4
                                    text-sm
                                    text-slate-700
                                    dark:text-slate-300
                                ">
                                    {{ $device->vendor_code ?? '—' }}
                                </td>

                                <td class="
                                    whitespace-nowrap
                                    px-6 py-4
                                    text-sm
                                    text-slate-700
                                    dark:text-slate-300
                                ">
                                    {{ $device->company_name ?? '—' }}
                                </td>

                                <td class="
                                    px-6 py-4
                                    text-sm
                                    text-slate-700
                                    dark:text-slate-300
                                    whitespace-nowrap
                                ">
                                    {{ $device->rut }}
                                </td>
                                    
                                <td class="
                                    px-6 py-4
                                    text-sm
                                    text-slate-700
                                    whitespace-nowrap
                                    dark:text-slate-300
                                ">
                                    {{ $device->email }}
                                </td>
                                    
                                <td class="
                                    px-6 py-4
                                    text-sm
                                    text-slate-700
                                    whitespace-nowrap
                                    dark:text-slate-300
                                ">
                                    {{ $device->observations ?? '—' }}
                                </td>    

                                <td class="
                                    px-6 py-4
                                    whitespace-nowrap
                                    text-center
                                    ">

                                    @if($device->status === 'active')
                                        <span class="
                                            inline-flex
                                            items-center
                                            rounded-full
                                            bg-green-500/20
                                            px-3 py-1
                                            text-xs
                                            font-bold
                                            text-green-700
                                            dark:text-green-300
                                        ">
                                            ACTIVO
                                        </span>

                                    @elseif($device->status === 'returned')
                                        <span class="
                                            inline-flex
                                            items-center
                                            rounded-full
                                            bg-slate-500/20
                                            px-3 py-1
                                            text-xs
                                            font-bold
                                            text-slate-700
                                            dark:text-slate-300
                                        ">
                                            DEVUELTO
                                        </span>

                                    @elseif($device->status === 'blocked')
                                        <span class="
                                            inline-flex
                                            items-center
                                            rounded-full
                                            bg-red-500/20
                                            px-3 py-1
                                            text-xs
                                            font-bold
                                            text-red-700
                                            dark:text-red-300
                                        ">
                                            BLOQUEADO
                                        </span>

                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td
                                    colspan="7"
                                    class="
                                        px-6 py-10
                                        whitespace-nowrap
                                        text-center
                                        justify-center
                                        text-sm
                                        text-slate-500
                                        dark:text-slate-400
                                    ">
                                        No existen registros.
                                </td>

                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
                {{-- PAGINATION --}}
            <div class="
                p-5
                border-t
                border-slate-200
                dark:border-slate-800
            ">
                {{ $devices->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL EDITAR --}}
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

        {{-- CAJA --}}
        <div class="
            w-full
            max-w-5xl

            rounded-2xl

            border
            border-slate-800

            bg-[#020817]

            p-6
        ">

            {{-- HEADER --}}
            <div class="
                flex
                items-center
                justify-between

                mb-6
            ">

                <div>

                    <h2 class="
                        text-2xl
                        font-bold
                        text-white
                    ">
                        Editar Celular
                    </h2>

                    <p class="
                        mt-1
                        text-sm
                        text-slate-400
                    ">
                        Modificar información del dispositivo
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

            {{-- FORM --}}
            <form
                method="POST"

                id="edit-form"
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

                    <div>

                        <label class="block mb-2 text-sm text-gray-300">
                            Nombre <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="text"
                            name="first_name"
                            id="edit-first_name"

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
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Apellido <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="last_name"
                            id="edit-last_name"
                            placeholder="Apellido"

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
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                                Modelo <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="phone_model"
                            id="edit-phone_model"
                            placeholder="Modelo"

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
                    <div>

                        <label class="block mb-2 text-sm text-gray-300">
                            Número <span class="text-red-400">*</span>
                        </label>

                        <div class="flex">

                            <span class="
                                inline-flex items-center px-4
                                rounded-l-xl
                                border border-r-0 border-slate-700
                                bg-slate-900
                                text-gray-300
                            ">
                                +56
                            </span>

                            <input
                                type="text"
                                name="phone_number"
                                id="edit-phone_number"

                                class="
                                    w-full
                                    rounded-r-xl
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

                    </div>
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            IMEI <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="imei"
                            id="edit-imei"
                            placeholder="IMEI"

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
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Cargo <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="position"
                            id="edit-position"
                            placeholder="Cargo"

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
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Área <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="department"
                            id="edit-department"
                            placeholder="Área"

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

                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Código Vendedor <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="vendor_code"
                            id="edit-vendor_code"
                            placeholder="Código vendedor"

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
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Empresa <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="company_name"
                            id="edit-company_name"
                            placeholder="Empresa"

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
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            RUT <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="rut"
                            id="edit-rut"
                            placeholder="RUT"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500e
                            "
                        >
                    </div>
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Correo Electrónico <span class="text-red-400">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="edit-email"
                            placeholder="Correo"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500e
                            "
                        >
                    </div>
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Fecha Entrega <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="text"
                            name="delivery_date"
                            id="edit-delivery_date"

                            placeholder="Seleccione fecha"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                            "
                        >

                    </div>
                    <div>
                        <label class="block mb-2 text-sm text-gray-300">
                            Estado <span class="text-red-400">*</span>
                        </label>
                        <select
                            name="status"
                            id="edit-status"

                            class="
                                w-full
                                rounded-xl
                                border border-slate-700
                                bg-slate-900
                                px-4 py-3
                                text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500e
                            "
                        >
                            <option value="active">
                                Activo
                            </option>

                            <option value="returned">
                                Devuelto
                            </option>

                            <option value="blocked">
                                Bloqueado
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mt-5">
                    <label class="block mb-2 text-sm text-gray-300">
                        Observaciones
                    </label>
                    <textarea
                        name="observations"
                        id="edit-observations"

                        placeholder="Observaciones"

                        class="
                            w-full
                            rounded-xl
                            border border-slate-700
                            bg-slate-900
                            px-4 py-3
                            text-white
                            focus:outline-none
                            focus:ring-2
                            focus:ring-blue-500e
                        "
                    ></textarea>
                </div>
                {{-- FOOTER --}}
                <div class="
                    flex
                    justify-end

                    mt-6
                ">

                    <button
                        type="submit"

                        class="
                            px-5 py-3

                            rounded-xl

                            bg-blue-600
                            hover:bg-blue-700

                            text-white
                            font-semibold

                            transition
                        "
                    >
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    
    </div>
    <script>
        const importButton = document.getElementById('import-button');
        const fileInput = document.getElementById('excel-file-input');
        const importForm = document.getElementById('excel-import-form');
        const buttonText = document.getElementById('import-button-text');

        importButton.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', () => {

            if (fileInput.files.length > 0) {

                importButton.disabled = true;

                importButton.classList.add('opacity-70');

                buttonText.innerText = 'Importando...';

                importForm.submit();

            }

        });

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

        /*
        |--------------------------------------------------------------------------
        | Abrir modal editar
        |--------------------------------------------------------------------------
        */
        
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                
                const id = button.dataset.id;
                
                /*
                |--------------------------------------------------------------------------
                | Número teléfono sin +56
                |--------------------------------------------------------------------------
                */
                const phoneNumber =
                    button.dataset.phone_number
                        ? button.dataset.phone_number.replace('+56', '')
                        : '';
                /*
                |--------------------------------------------------------------------------
                | Action form
                |--------------------------------------------------------------------------
                */
                editForm.action = `/employee-phones/${id}`;
                /*
                |--------------------------------------------------------------------------
                | Relleno de Inputs
                |--------------------------------------------------------------------------
                */
                document.getElementById('edit-first_name').value =
                    button.dataset.first_name ?? '';
                document.getElementById('edit-last_name').value =
                    button.dataset.last_name ?? '';
                document.getElementById('edit-phone_model').value =
                    button.dataset.phone_model ?? '';
                document.getElementById('edit-phone_number').value =
                    phoneNumber;
                document.getElementById('edit-imei').value =
                    button.dataset.imei ?? '';
                document.getElementById('edit-position').value =
                    button.dataset.position ?? '';
                document.getElementById('edit-department').value =
                    button.dataset.department ?? '';
                document.getElementById('edit-vendor_code').value =
                    button.dataset.vendor_code ?? '';
                document.getElementById('edit-company_name').value =
                    button.dataset.company_name ?? '';
                document.getElementById('edit-rut').value =
                    button.dataset.rut ?? '';
                document.getElementById('edit-email').value =
                    button.dataset.email ?? '';
                document.getElementById('edit-observations').value =
                    button.dataset.observations ?? '';
                const rawDate = button.dataset.delivery_date ?? '';
                if (rawDate) {

                    const date = new Date(rawDate);

                    const formattedDate =
                        date.toLocaleDateString('es-CL');

                    document.getElementById('edit-delivery_date').value =
                        formattedDate;

                }
                document.getElementById('edit-status').value =
                    button.dataset.status ?? '';
                /*
                |--------------------------------------------------------------------------
                | Fecha entrega
                |--------------------------------------------------------------------------
                */
                
            });
        });

        /*
        |--------------------------------------------------------------------------
        | Cerrar modal
        |--------------------------------------------------------------------------
        */

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