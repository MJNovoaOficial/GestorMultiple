<x-app-layout>

    <div class="w-full max-w-[2400px] mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-8 ">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>

                <h1 class="
                    text-3xl
                    font-bold
                    text-white
                ">
                    Celulares Corporativos
                </h1>

                <p class="
                    mt-1
                    text-sm
                    text-slate-400
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
    <div class="py-8">

        <div class="w-full max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ALERTAS --}}

            @if(session('success'))

                <div class="
                    mb-6

                    rounded-2xl

                    border border-green-500/20

                    bg-green-500/10

                    px-5 py-4

                    text-green-700
                    dark:text-green-300
                ">

                    {{ session('success') }}

                </div>

            @endif

            {{-- CARDS --}}

            <div class="
                grid
                grid-cols-1
                md:grid-cols-2
                xl:grid-cols-4

                gap-5

                mb-8
            ">

                {{-- ACTIVOS --}}

                <div class="
                    rounded-2xl

                    border
                    border-green-300
                    dark:border-green-500/20

                    bg-green-100
                    dark:bg-green-500/10

                    p-5
                ">

                    <p class="
                        text-sm
                        font-semibold

                        text-green-700
                        dark:text-green-300
                    ">

                        ACTIVOS

                    </p>

                    <h3 class="
                        mt-3

                        text-3xl
                        font-bold

                        text-green-900
                        dark:text-green-100
                    ">

                        {{ $activeCount }}

                    </h3>

                </div>

                {{-- DEVUELTOS --}}

                <div class="
                    rounded-2xl

                    border
                    border-slate-300
                    dark:border-slate-500/20

                    bg-slate-100
                    dark:bg-slate-500/10

                    p-5
                ">

                    <p class="
                        text-sm
                        font-semibold

                        text-slate-700
                        dark:text-slate-300
                    ">

                        DEVUELTOS

                    </p>

                    <h3 class="
                        mt-3

                        text-3xl
                        font-bold

                        text-slate-900
                        dark:text-slate-100
                    ">

                        {{ $returnedCount }}

                    </h3>

                </div>

                {{-- BLOQUEADOS --}}

                <div class="
                    rounded-2xl

                    border
                    border-red-300
                    dark:border-red-500/20

                    bg-red-100
                    dark:bg-red-500/10

                    p-5
                ">

                    <p class="
                        text-sm
                        font-semibold

                        text-red-700
                        dark:text-red-300
                    ">

                        BLOQUEADOS

                    </p>

                    <h3 class="
                        mt-3

                        text-3xl
                        font-bold

                        text-red-900
                        dark:text-red-100
                    ">

                        {{ $blockedCount }}

                    </h3>

                </div>

                {{-- TOTAL --}}

                <div class="
                    rounded-2xl

                    border
                    border-blue-300
                    dark:border-blue-500/20

                    bg-blue-100
                    dark:bg-blue-500/10

                    p-5
                ">

                    <p class="
                        text-sm
                        font-semibold

                        text-blue-700
                        dark:text-blue-300
                    ">

                        TOTAL REGISTROS

                    </p>

                    <h3 class="
                        mt-3

                        text-3xl
                        font-bold

                        text-blue-900
                        dark:text-blue-100
                    ">

                        {{ $totalCount }}

                    </h3>

                </div>

            </div>

            {{-- TABLA --}}

            <div class="
                overflow-hidden

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
                                "
                            >

                                Buscar

                            </button>

                        </div>

                    </form>

                </div>

                {{-- TABLE --}}
                {{-- TOP SCROLL --}}

                <div
                    id="top-scroll"

                    class="
                        overflow-x-auto
                        overflow-y-hidden

                        h-4

                        border-b
                        border-slate-200
                        dark:border-slate-800
                    "
                >

                    <<div
                        id="top-scroll-content"

                        class="h-px"
                    ></div>

                </div>

                {{-- TABLE SCROLL --}}

                <div
                    id="table-scroll"

                    class="overflow-x-auto"
                >

                        <table class="min-w-[2400px] w-full">

                        <thead class="
                            bg-slate-100
                            dark:bg-slate-900
                        ">

                            <tr>
                                <th class="
                                    px-6 py-4
                                    text-left
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
                                    uppercase
                                    tracking-wider
                                    text-slate-500
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
                                ">
                                    Acciones
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

                                    <td class="
                                        px-6 py-4
                                    ">

                                        <div class="
                                            flex
                                            items-center
                                            justify-center

                                            gap-2
                                        ">

                                            <a
                                                href="{{ route('employee-phones.edit', $device) }}"

                                                class="
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
                                            >

                                                ✏️

                                            </a>

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
                                            justify-center
                                            text-sm

                                            text-slate-500
                                            dark:text-slate-400
                                        "
                                    >

                                        No existen registros.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

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

    </div>
    <script>

        const importButton = document.getElementById('import-button');
        const fileInput = document.getElementById('excel-file-input');
        const form = document.getElementById('excel-import-form');
        const buttonText = document.getElementById('import-button-text');

        importButton.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', () => {

            if (fileInput.files.length > 0) {

                importButton.disabled = true;

                importButton.classList.add('opacity-70');

                buttonText.innerText = 'Importando...';

                form.submit();

            }

        });

        document.addEventListener('DOMContentLoaded', () => {

            const topScroll = document.getElementById('top-scroll');

            const tableScroll = document.getElementById('table-scroll');

            const topScrollContent = document.getElementById('top-scroll-content');

            const table = tableScroll.querySelector('table');

            // Sincronizar ancho REAL de tabla
            topScrollContent.style.width = table.scrollWidth + 'px';

            // Scroll superior → tabla
            topScroll.addEventListener('scroll', () => {

                tableScroll.scrollLeft = topScroll.scrollLeft;

            });

            // Tabla → scroll superior
            tableScroll.addEventListener('scroll', () => {

                topScroll.scrollLeft = tableScroll.scrollLeft;

            });

            // Recalcular al cambiar tamaño ventana
            window.addEventListener('resize', () => {

                topScrollContent.style.width = table.scrollWidth + 'px';

            });

        });

        
        document.addEventListener('DOMContentLoaded', () => {

            const searchInput = document.getElementById('search-input');

            const searchForm = document.getElementById('search-form');

            let timeout = null;

            searchInput.addEventListener('input', () => {

                clearTimeout(timeout);

                timeout = setTimeout(() => {

                    searchForm.submit();

                }, 500);

            });

        });
    </script>
</x-app-layout>