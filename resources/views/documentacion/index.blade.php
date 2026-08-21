<x-app-layout>

    <div class="p-6">

        {{-- HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">

            <div>
                <h1 class="text-3xl font-bold text-slate-700 dark:text-slate-200">
                    Manuales y Documentación
                </h1>

                <p class="text-slate-500 dark:text-slate-400 mt-1">
                    Manuales, procedimientos y documentación interna.
                </p>
            </div>

            <div>
                <button
                    type="button"
                    id="open-category-modal"
                    class="
                        inline-flex
                        items-center
                        gap-2
                        rounded-xl
                        bg-blue-600
                        hover:bg-blue-700
                        px-4
                        py-2.5
                        text-sm
                        font-semibold
                        text-white
                        transition
                    "
                >
                    <img
                        src="{{ asset('images/documentacion/carpeta.png') }}"
                        alt="Nueva Carpeta"
                        class="w-5 h-5 object-contain"
                    >
                    <span>
                        Nueva Carpeta
                    </span>
                </button>
            </div>

        </div>


        {{-- BUSCADOR + OPCIONES --}}
        <div
            class="
                mb-6
                rounded-2xl
                border
                border-slate-200
                dark:border-slate-800
                bg-white
                dark:bg-[#020817]
                p-5
            "
        >

            <div class="flex flex-col xl:flex-row gap-4">

                {{-- BUSCADOR --}}
                <form
                    method="GET"
                    action="{{ route('documentacion.index') }}"
                    class="flex-1 flex gap-3"
                >

                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Buscar categorías..."
                        class="
                            flex-1
                            rounded-xl
                            border
                            border-slate-300
                            dark:border-slate-700
                            bg-white
                            dark:bg-slate-900
                            px-4
                            py-3
                            text-sm
                            text-slate-700
                            dark:text-white
                            focus:outline-none
                            focus:ring-2
                            focus:ring-blue-500
                        "
                    >

                    <button
                        type="submit"
                        class="
                            px-5
                            py-3
                            rounded-xl
                            bg-blue-600
                            hover:bg-blue-700
                            text-white
                            font-semibold
                            transition
                        "
                    >
                        Buscar
                    </button>

                </form>


                {{-- ORDENAMIENTO --}}
                <form
                    method="GET"
                    action="{{ route('documentacion.index') }}"
                    class="
                        flex
                        flex-col
                        sm:flex-row
                        gap-3
                    "
                >

                    @if($search)
                        <input
                            type="hidden"
                            name="search"
                            value="{{ $search }}"
                        >
                    @endif

                    <select
                        name="sort"
                        onchange="this.form.submit()"
                        class="
                            rounded-xl
                            border
                            border-slate-300
                            dark:border-slate-700
                            bg-white
                            dark:bg-slate-900
                            px-4
                            py-3
                            text-sm
                            text-slate-700
                            dark:text-white
                            focus:outline-none
                            focus:ring-2
                            focus:ring-blue-500
                        "
                    >

                        <option
                            value="name"
                            {{ $sort === 'name' ? 'selected' : '' }}
                        >
                            Nombre
                        </option>

                        <option
                            value="updated_at"
                            {{ $sort === 'updated_at' ? 'selected' : '' }}
                        >
                            Última modificación
                        </option>

                        <option
                            value="documents_count"
                            {{ $sort === 'documents_count' ? 'selected' : '' }}
                        >
                            Cantidad de documentos
                        </option>

                    </select>


                    <select
                        name="direction"
                        onchange="this.form.submit()"
                        class="
                            rounded-xl
                            border
                            border-slate-300
                            dark:border-slate-700
                            bg-white
                            dark:bg-slate-900
                            px-4
                            py-3
                            text-sm
                            text-slate-700
                            dark:text-white
                            focus:outline-none
                            focus:ring-2
                            focus:ring-blue-500
                        "
                    >

                        <option
                            value="asc"
                            {{ $direction === 'asc' ? 'selected' : '' }}
                        >
                            Ascendente
                        </option>

                        <option
                            value="desc"
                            {{ $direction === 'desc' ? 'selected' : '' }}
                        >
                            Descendente
                        </option>

                    </select>

                </form>

            </div>

        </div>


        {{-- SELECTOR DE VISTA --}}
        <div class="flex items-center justify-end gap-2 mb-4">

            <a
                href="{{ route('documentacion.trash') }}"
                class="
                    inline-flex
                    items-center
                    gap-2
                    px-4
                    py-2
                    rounded-xl
                    bg-red-600
                    hover:bg-red-700
                    text-white
                    font-semibold
                    transition
                "
            >
                <img
                    src="{{ asset('images/documentacion/papelera.png') }}"
                    alt="Papelera"
                    class="w-6 h-6 object-contain"
                >

                Papelera
            </a>

            <button
                type="button"
                id="grid-view-btn"
                class="
                    px-4
                    py-2
                    rounded-xl
                    bg-blue-600
                    text-white
                    font-semibold
                    transition
                "
            >
                ▦ Iconos
            </button>

            <button
                type="button"
                id="list-view-btn"
                class="
                    px-4
                    py-2
                    rounded-xl
                    bg-slate-200
                    dark:bg-slate-800
                    text-slate-700
                    dark:text-slate-300
                    font-semibold
                    transition
                "
            >
                ☷ Lista
            </button>

        </div>


        {{-- VISTA ICONOS --}}
        <div
            id="grid-view"
            class="
                grid
                grid-cols-1
                sm:grid-cols-2
                lg:grid-cols-3
                xl:grid-cols-4
                gap-5
            "
        >

            @forelse($categories as $category)

                <div
                    class="
                        relative
                        group
                        rounded-2xl
                        border
                        border-slate-200
                        dark:border-slate-800
                        bg-white
                        dark:bg-[#020817]
                        p-6
                        hover:border-blue-500
                        hover:shadow-lg
                        transition
                    "
                >

                    {{-- OPCIONES DE CATEGORÍA --}}
                    <div class="absolute top-3 right-3 z-20">

                        <button
                            type="button"
                            class="
                                w-9
                                h-9
                                rounded-xl
                                flex
                                items-center
                                justify-center
                                text-slate-400
                                hover:text-white
                                hover:bg-slate-800
                                dark:hover:bg-slate-700
                                transition
                            "
                            onclick="toggleCategoryMenu(event, {{ $category->id }})"
                        >
                            ⋮
                        </button>


                        {{-- MENÚ DE OPCIONES --}}
                        <div
                            id="category-menu-{{ $category->id }}"
                            class="
                                hidden
                                absolute
                                right-0
                                top-10
                                w-40
                                rounded-xl
                                border
                                border-slate-200
                                dark:border-slate-700
                                bg-white
                                dark:bg-slate-900
                                shadow-xl
                                overflow-hidden
                            "
                        >

                            {{-- EDITAR --}}
                            <button
                                type="button"
                                class="
                                    w-full
                                    flex
                                    items-center
                                    gap-3
                                    px-4
                                    py-3
                                    text-sm
                                    text-slate-700
                                    dark:text-slate-200
                                    hover:bg-slate-100
                                    border-b
                                    border-slate-200
                                    dark:border-slate-700
                                    dark:hover:bg-slate-800
                                    transition
                                "
                                onclick="openCategoryEditModal(
                                    event, 
                                    {{ $category->id }},
                                    @js($category->name),
                                    @js($category->description),
                                    @js($category->image)
                                )"
                            >
                                <span>✏️</span>
                                <span>Editar</span>
                            </button>


                            {{-- ELIMINAR --}}
                            <button
                                type="button"
                                class="
                                    w-full
                                    flex
                                    items-center
                                    gap-3
                                    px-4
                                    py-3
                                    text-sm
                                    text-red-600
                                    hover:bg-red-50
                                    dark:hover:bg-red-950/30
                                    transition
                                "
                                onclick="openCategoryDeleteModal(
                                    event,
                                    {{ $category->id }},
                                    @js($category->name)
                                )"
                            >
                                <span>🗑️</span>
                                <span>Eliminar</span>
                            </button>

                        </div>

                    </div>


                    {{-- CONTENIDO DE LA CATEGORÍA --}}
                    <a
                        href="{{ route('documentacion.category', $category) }}"
                        class="block"
                    >

                        <div class="flex flex-col items-center text-center">

                            {{-- IMAGEN --}}
                            <div
                                class="
                                    w-24
                                    h-24
                                    mb-4
                                    rounded-2xl
                                    bg-slate-100
                                    dark:bg-slate-900
                                    flex
                                    items-center
                                    justify-center
                                    overflow-hidden
                                "
                            >

                                @if($category->image)

                                    <img
                                        src="{{ asset('storage/' . $category->image) }}"
                                        alt="{{ $category->name }}"
                                        class="w-full h-full object-contain p-2"
                                    >

                                @else

                                    <img
                                        src="{{ asset('images/documentacion/default-category.png') }}"
                                        alt="Categoría"
                                        class="w-full h-full object-contain p-4"
                                    >

                                @endif

                            </div>


                            {{-- NOMBRE --}}
                            <h2
                                class="
                                    text-lg
                                    font-bold
                                    text-slate-700
                                    dark:text-slate-200
                                    group-hover:text-blue-500
                                    transition
                                "
                            >
                                {{ $category->name }}
                            </h2>


                            {{-- CANTIDAD DE DOCUMENTOS --}}
                            <p
                                class="
                                    mt-1
                                    text-sm
                                    text-slate-500
                                    dark:text-slate-400
                                "
                            >
                                {{ $category->documents_count }}
                                {{ $category->documents_count === 1 ? 'documento' : 'documentos' }}
                            </p>

                        </div>

                    </a>

                </div>


            @empty

                <div
                    class="
                        col-span-full
                        rounded-2xl
                        border
                        border-dashed
                        border-slate-300
                        dark:border-slate-700
                        p-12
                        text-center
                    "
                >

                    <div class="text-5xl mb-4">
                        📚
                    </div>

                    <h2
                        class="
                            text-xl
                            font-semibold
                            text-slate-700
                            dark:text-slate-200
                        "
                    >
                        No hay categorías
                    </h2>

                    <p
                        class="
                            mt-2
                            text-slate-500
                            dark:text-slate-400
                        "
                    >
                        Crea la primera categoría para comenzar a organizar la documentación.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- VISTA LISTA --}}
        <div
            id="list-view"
            class="
                hidden
                overflow-hidden
                rounded-2xl
                border
                border-slate-200
                dark:border-slate-800
                bg-white
                dark:bg-[#020817]
            "
        >

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-100 dark:bg-slate-900">

                        <tr>

                            <th class="px-6 py-4 text-left">
                                Categoría
                            </th>

                            <th class="px-6 py-4 text-center">
                                Documentos
                            </th>

                            <th class="px-6 py-4 text-center">
                                Última modificación
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($categories as $category)

                            <tr
                                class="
                                    border-t
                                    border-slate-200
                                    dark:border-slate-800
                                    hover:bg-slate-50
                                    dark:hover:bg-slate-900/50
                                    transition
                                "
                            >

                                <td class="px-6 py-4">

                                    <a
                                        href="#"
                                        class="
                                            flex
                                            items-center
                                            gap-4
                                            text-slate-700
                                            dark:text-slate-200
                                            hover:text-blue-500
                                            transition
                                        "
                                    >

                                        <div
                                            class="
                                                w-12
                                                h-12
                                                rounded-xl
                                                bg-slate-100
                                                dark:bg-slate-900
                                                flex
                                                items-center
                                                justify-center
                                                overflow-hidden
                                                flex-shrink-0
                                            "
                                        >

                                            @if($category->image)
                                                <img
                                                    src="{{ asset('storage/' . $category->image) }}"
                                                    alt="{{ $category->name }}"
                                                    class="w-full h-full object-contain p-1"
                                                >
                                            @else
                                                <img
                                                    src="{{ asset('images/documentacion/default-category.png') }}"
                                                    alt="Categoría"
                                                    class="w-full h-full object-contain p-1"
                                                >
                                            @endif

                                        </div>

                                        <div>

                                            <div class="font-semibold">
                                                {{ $category->name }}
                                            </div>

                                            @if($category->description)

                                                <div
                                                    class="
                                                        text-xs
                                                        text-slate-500
                                                        dark:text-slate-400
                                                        mt-1
                                                    "
                                                >
                                                    {{ $category->description }}
                                                </div>

                                            @endif

                                        </div>

                                    </a>

                                </td>


                                <td
                                    class="
                                        px-6
                                        py-4
                                        text-center
                                        text-slate-600
                                        dark:text-slate-300
                                    "
                                >
                                    {{ $category->documents_count }}
                                </td>


                                <td
                                    class="
                                        px-6
                                        py-4
                                        text-center
                                        text-slate-600
                                        dark:text-slate-300
                                    "
                                >
                                    {{ $category->updated_at?->format('d/m/Y H:i') }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="3"
                                    class="
                                        px-6
                                        py-10
                                        text-center
                                        text-slate-500
                                    "
                                >
                                    No hay categorías registradas.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- CAMBIO DE VISTA --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const gridView = document.getElementById('grid-view');
            const listView = document.getElementById('list-view');

            const gridButton = document.getElementById('grid-view-btn');
            const listButton = document.getElementById('list-view-btn');

            /*
            |--------------------------------------------------------------------------
            | VISTA ICONOS
            |--------------------------------------------------------------------------
            */

            function showGrid() {

                gridView.classList.remove('hidden');
                listView.classList.add('hidden');

                gridButton.classList.remove(
                    'bg-slate-200',
                    'dark:bg-slate-800',
                    'text-slate-700',
                    'dark:text-slate-300'
                );

                gridButton.classList.add(
                    'bg-blue-600',
                    'text-white'
                );


                listButton.classList.remove(
                    'bg-blue-600',
                    'text-white'
                );

                listButton.classList.add(
                    'bg-slate-200',
                    'dark:bg-slate-800',
                    'text-slate-700',
                    'dark:text-slate-300'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | VISTA LISTA
            |--------------------------------------------------------------------------
            */

            function showList() {

                listView.classList.remove('hidden');
                gridView.classList.add('hidden');

                listButton.classList.remove(
                    'bg-slate-200',
                    'dark:bg-slate-800',
                    'text-slate-700',
                    'dark:text-slate-300'
                );

                listButton.classList.add(
                    'bg-blue-600',
                    'text-white'
                );


                gridButton.classList.remove(
                    'bg-blue-600',
                    'text-white'
                );

                gridButton.classList.add(
                    'bg-slate-200',
                    'dark:bg-slate-800',
                    'text-slate-700',
                    'dark:text-slate-300'
                );
            }

            gridButton.addEventListener('click', showGrid);
            listButton.addEventListener('click', showList);

            /*
            |--------------------------------------------------------------------------
            | CERRAR MENÚS DE CATEGORÍAS
            |--------------------------------------------------------------------------
            */

            document.addEventListener('click', () => {

                document
                    .querySelectorAll('[id^="category-menu-"]')
                    .forEach(menu => {

                        menu.classList.add('hidden');

                    });

            });

            /*
            |--------------------------------------------------------------------------
            | CERRAR MODAL DE EDICIÓN
            |--------------------------------------------------------------------------
            */

            const closeEditButton = document.getElementById(
                'close-category-edit-modal'
            );

            const cancelEditButton = document.getElementById(
                'cancel-category-edit-modal'
            );

            const editModal = document.getElementById(
                'category-edit-modal'
            );

            const closeDeleteButton = document.getElementById(
                'close-category-delete-modal'
            );

            const cancelDeleteButton = document.getElementById(
                'cancel-category-delete-modal'
            );

            const deleteModal = document.getElementById(
                'category-delete-modal'
            );

            // Botón X
            if (closeEditButton) {

                closeEditButton.addEventListener('click', () => {

                    closeCategoryEditModal();

                });

            }

            // Botón Cancelar
            if (cancelEditButton) {

                cancelEditButton.addEventListener('click', () => {

                    closeCategoryEditModal();

                });

            }

            // Clic fuera del modal
            if (editModal) {

                editModal.addEventListener('click', (event) => {

                    if (event.target === editModal) {

                        closeCategoryEditModal();

                    }

                });

            }

            // X
            if (closeDeleteButton) {

                closeDeleteButton.addEventListener('click', () => {

                    closeCategoryDeleteModal();

                });

            }

            // Cancelar
            if (cancelDeleteButton) {

                cancelDeleteButton.addEventListener('click', () => {

                    closeCategoryDeleteModal();

                });

            }

            // Click fuera
            if (deleteModal) {

                deleteModal.addEventListener('click', (event) => {

                    if (event.target === deleteModal) {

                        closeCategoryDeleteModal();

                    }

                });

            }

        });

        /*
        |--------------------------------------------------------------------------
        | MENÚ DE CATEGORÍAS
        |--------------------------------------------------------------------------
        */

        window.toggleCategoryMenu = function (event, categoryId) {

            event.stopPropagation();

            const menu = document.getElementById(
                `category-menu-${categoryId}`
            );

            if (!menu) {
                return;
            }


            // Cerrar los demás menús
            document
                .querySelectorAll('[id^="category-menu-"]')
                .forEach(otherMenu => {

                    if (otherMenu !== menu) {

                        otherMenu.classList.add('hidden');

                    }

                });


            // Abrir/cerrar el menú seleccionado
            menu.classList.toggle('hidden');

        };


        /*
        |--------------------------------------------------------------------------
        | ABRIR MODAL DE EDICIÓN
        |--------------------------------------------------------------------------
        */

        window.openCategoryEditModal = function (
            event,
            categoryId,
            categoryName,
            categoryDescription,
            categoryImage
        ) {

            event.stopPropagation();

            const modal = document.getElementById(
                'category-edit-modal'
            );

            const form = document.getElementById(
                'category-edit-form'
            );

            const nameInput = document.getElementById(
                'edit-category-name'
            );

            const descriptionInput = document.getElementById(
                'edit-category-description'
            );

            const imagePreview = document.getElementById(
                'edit-category-image-preview'
            );

            const removeImageContainer = document.getElementById(
                'remove-category-image-container'
            );

            const removeImageCheckbox = document.getElementById(
                'remove-category-image'
            );


            if (!modal || !form) {
                return;
            }


            // Cargar nombre
            nameInput.value = categoryName ?? '';


            // Cargar descripción
            descriptionInput.value = categoryDescription ?? '';


            // Configurar URL del formulario
            form.action = `/documentacion/${categoryId}`;


            // Cargar imagen
            if (categoryImage) {

                imagePreview.src =
                    `/storage/${categoryImage}`;

                removeImageContainer.classList.remove('hidden');

            } else {

                imagePreview.src =
                    '/images/documentacion/default-category.png';

                removeImageContainer.classList.add('hidden');

            }


            // Reiniciar checkbox
            removeImageCheckbox.checked = false;


            // Mostrar modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');

        };


        /*
        |--------------------------------------------------------------------------
        | CERRAR MODAL DE EDICIÓN
        |--------------------------------------------------------------------------
        */

        window.closeCategoryEditModal = function () {

            const modal = document.getElementById(
                'category-edit-modal'
            );

            const imageInput = document.getElementById(
                'edit-category-image'
            );

            const removeImageCheckbox = document.getElementById(
                'remove-category-image'
            );


            if (!modal) {
                return;
            }


            // Ocultar modal
            modal.classList.add('hidden');
            modal.classList.remove('flex');


            // Limpiar archivo seleccionado
            if (imageInput) {

                imageInput.value = '';

            }


            // Desmarcar checkbox
            if (removeImageCheckbox) {

                removeImageCheckbox.checked = false;

            }

        };

        window.openCategoryDeleteModal = function (
            event,
            categoryId,
            categoryName
        ) {

            event.stopPropagation();

            const modal = document.getElementById(
                'category-delete-modal'
            );

            const form = document.getElementById(
                'category-delete-form'
            );

            const categoryNameElement = document.getElementById(
                'category-delete-name'
            );


            if (!modal || !form) {
                return;
            }


            // Mostrar nombre de la categoría
            categoryNameElement.textContent = categoryName;


            // Configurar formulario
            form.action = `/documentacion/${categoryId}`;


            // Mostrar modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');

        };

        window.closeCategoryDeleteModal = function () {

            const modal = document.getElementById(
                'category-delete-modal'
            );

            if (!modal) {
                return;
            }

            modal.classList.add('hidden');
            modal.classList.remove('flex');

        };

    </script>

@include('documentacion.partials.category-modal')
@include('documentacion.partials.category-edit-modal')
@include('documentacion.partials.category-delete-modal')
</x-app-layout> 