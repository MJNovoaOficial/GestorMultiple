<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- ENCABEZADO --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <div class="flex items-center gap-3">
                        <div
                            class="
                                w-12
                                h-12
                                rounded-2xl
                                bg-slate-100
                                dark:bg-slate-900
                                flex
                                items-center
                                justify-center
                            "
                        >

                            <img
                                src="{{ asset('images/documentacion/papelera.png') }}"
                                alt="Papelera"
                                class="w-8 h-8 object-contain"
                            >
                        </div>

                        <div>
                            <h1
                                class="
                                    text-2xl
                                    font-bold
                                    text-slate-800
                                    dark:text-white
                                "
                            >
                                Papelera
                            </h1>

                            <p
                                class="
                                    mt-1
                                    text-sm
                                    text-slate-500
                                    dark:text-slate-400
                                "
                            >
                                Categorías eliminadas de la documentación.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- VOLVER --}}
                <a
                    href="{{ route('documentacion.index') }}"
                    class="
                        inline-flex
                        items-center
                        gap-2
                        px-4
                        py-2.5
                        rounded-xl
                        bg-blue-600
                        hover:bg-blue-700
                        text-white
                        font-semibold
                        transition
                    "
                >
                    <img
                        src="{{ asset('images/documentacion/atras.png') }}"
                        alt="Volver"
                        class="w-5 h-5 object-contain"
                    >
                    Volver a documentación
                </a>

            </div>

            {{-- INFORMACIÓN --}}
            <div
                class="
                    mb-6
                    rounded-2xl
                    border
                    border-slate-200
                    dark:border-slate-800
                    bg-white
                    dark:bg-[#020817]
                    px-5
                    py-4
                "
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p
                            id="trash-info-title"
                            class="
                                text-sm
                                font-semibold
                                text-slate-700
                                dark:text-slate-200
                            "
                        >
                            Categorías eliminadas
                        </p>
                        <p
                            id="trash-info-description"
                            class="
                                mt-1
                                text-xs
                                text-slate-500
                                dark:text-slate-400
                            "
                        >
                            Las categorías pueden restaurarse posteriormente.
                        </p>
                    </div>

                    <div
                        id="trash-info-count"
                        class="
                            px-3
                            py-1.5
                            rounded-xl
                            bg-slate-100
                            dark:bg-slate-800
                            text-sm
                            font-bold
                            text-slate-700
                            dark:text-slate-200
                        "
                    >
                        {{ $categories->count() }}
                    </div>
                </div>
            </div>
            
            {{-- Contenido de Categorías --}}
            <div id="trash-content-categories">
                @if($categories->count())
                    <div
                        class="
                            grid
                            grid-cols-1
                            sm:grid-cols-2
                            lg:grid-cols-3
                            xl:grid-cols-4
                            gap-6
                        "
                    >
                        @foreach($categories as $category)
                            <div
                                class="
                                    relative
                                    rounded-2xl
                                    border
                                    border-slate-200
                                    dark:border-slate-800
                                    bg-white
                                    dark:bg-[#020817]
                                    p-6
                                    shadow-sm
                                "
                            >
                                {{-- OPCIONES --}}
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
                                        onclick="toggleTrashMenu(event, {{ $category->id }})"
                                    >
                                        ⋮
                                    </button>

                                    {{-- MENÚ --}}
                                    <div
                                        id="trash-menu-{{ $category->id }}"
                                        class="
                                            hidden
                                            absolute
                                            right-0
                                            top-10
                                            w-52
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
                                        {{-- RESTAURAR --}}
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
                                            onclick="openCategoryRestoreModal(
                                                event,
                                                {{ $category->id }},
                                                @js($category->name)
                                            )"
                                        >
                                            <span>♻️</span>
                                            <span>Restaurar</span>
                                        </button>

                                        {{-- ELIMINAR DEFINITIVAMENTE --}}
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
                                            onclick="openCategoryPermanentDeleteModal(
                                                event,
                                                {{ $category->id }},
                                                @js($category->name)
                                            )"
                                        >
                                            <span>🗑️</span>
                                            <span>Eliminar definitivamente</span>
                                        </button>
                                    </div>
                                </div>
                                {{-- CONTENIDO --}}
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
                                        "
                                    >
                                        {{ $category->name }}
                                    </h2>

                                    {{-- DOCUMENTOS --}}
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

                                    {{-- FECHA DE ELIMINACIÓN --}}
                                    <div
                                        class="
                                            mt-4
                                            px-3
                                            py-1.5
                                            rounded-lg
                                            bg-red-50
                                            dark:bg-red-950/30
                                            text-xs
                                            font-medium
                                            text-red-600
                                            dark:text-red-400
                                        "
                                    >
                                        Eliminado el
                                        {{ $category->deleted_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- PAPELERA VACÍA --}}
                    <div
                        class="
                            rounded-2xl
                            border
                            border-dashed
                            border-slate-300
                            dark:border-slate-700
                            bg-white
                            dark:bg-[#020817]
                            p-16
                            text-center
                        "
                    >
                        <div
                            class="
                                w-24
                                h-24
                                mx-auto
                                mb-6
                                rounded-3xl
                                bg-slate-100
                                dark:bg-slate-900
                                flex
                                items-center
                                justify-center
                            "
                        >
                            <img
                                src="{{ asset('images/documentacion/papelera.png') }}"
                                alt="Papelera vacía"
                                class="w-16 h-16 object-contain"
                            >
                        </div>

                        <h2
                            class="
                                text-xl
                                font-bold
                                text-slate-700
                                dark:text-slate-200
                            "
                        >
                            La papelera está vacía
                        </h2>

                        <p
                            class="
                                mt-2
                                text-sm
                                text-slate-500
                                dark:text-slate-400
                            "
                        >
                            No hay categorías eliminadas actualmente.
                        </p>

                        <a
                            href="{{ route('documentacion.index') }}"
                            class="
                                inline-flex
                                items-center
                                gap-2
                                mt-6
                                px-5
                                py-2.5
                                rounded-xl
                                bg-blue-600
                                hover:bg-blue-700
                                text-white
                                font-semibold
                                transition
                            "
                        >
                            <img
                                src="{{ asset('images/documentacion/atras.png') }}"
                                alt="Volver"
                                class="w-5 h-5 object-contain"
                            >
                                Volver a documentación
                        </a>
                    </div>
                @endif
            </div>
            {{-- CONTENIDO DOCUMENTOS --}}
            <div
                id="trash-content-documents"
                class="hidden"
            >
                @if($documents->count())
                    <div
                        class="
                            rounded-2xl
                            border
                            border-slate-200
                            dark:border-slate-800
                            bg-white
                            dark:bg-[#020817]
                            overflow-hidden
                        "
                    >
                        @foreach($documents as $document)
                            {{-- DOCUMENTO ELIMINADO --}}
                            <div
                                class="
                                    flex
                                    items-center
                                    gap-4
                                    px-5
                                    py-4
                                    border-b
                                    border-slate-200
                                    dark:border-slate-800
                                    last:border-b-0
                                "
                            >
                                <div class="flex-1 min-w-0">
                                    <h2
                                        class="
                                            text-sm
                                            font-bold
                                            text-slate-700
                                            dark:text-slate-200
                                            truncate
                                        "
                                    >
                                        {{ $document->name }}
                                    </h2>

                                    <p
                                        class="
                                            mt-1
                                            text-sm
                                            text-slate-500
                                            dark:text-slate-400
                                            truncate
                                        "
                                    >
                                        {{ $document->description ?: 'Sin descripción' }}
                                    </p>
                                    <div
                                        class="
                                            flex
                                            flex-wrap
                                            items-center
                                            gap-x-3
                                            gap-y-1
                                            mt-2
                                            text-xs
                                            text-slate-400
                                            dark:text-slate-500
                                        "
                                    >
                                        <span>
                                            {{ strtoupper(pathinfo($document->file_name, PATHINFO_EXTENSION)) }}
                                        </span>
                                        <span>•</span>
                                        <span>
                                            {{ $document->category->name ?? 'Sin categoría' }}
                                        </span>
                                        <span>•</span>
                                        <span>
                                            Eliminado el
                                            {{ $document->deleted_at->format('d/m/Y H:i') }}
                                        </span>
                                        <span>•</span>
                                        <span>
                                            {{ $document->creator->name ?? 'Usuario desconocido' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- OPCIONES --}}
                                <div class="relative">

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
                                        onclick="toggleDocumentTrashMenu(
                                            event,
                                            {{ $document->id }}
                                        )"
                                    >
                                        ⋮
                                    </button>

                                    <div
                                        id="document-trash-menu-{{ $document->id }}"
                                        class="
                                            hidden
                                            absolute
                                            right-0
                                            top-10
                                            w-52
                                            rounded-xl
                                            border
                                            border-slate-200
                                            dark:border-slate-700
                                            bg-white
                                            dark:bg-slate-900
                                            shadow-xl
                                            overflow-hidden
                                            z-30
                                        "
                                    >
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
                                                dark:hover:bg-slate-800
                                                transition
                                            "
                                            onclick="openDocumentRestoreModal(
                                                event,
                                                {{ $document->id }},
                                                @js($document->name)
                                            )"
                                        >
                                            <span>♻️</span>
                                            <span>Restaurar</span>
                                        </button>

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
                                            onclick="openDocumentPermanentDeleteModal(
                                                event,
                                                {{ $document->id }},
                                                @js($document->name)
                                            )"
                                        >
                                            <span>🗑️</span>
                                            <span>Eliminar definitivamente</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="
                            rounded-2xl
                            border
                            border-dashed
                            border-slate-300
                            dark:border-slate-700
                            bg-white
                            dark:bg-[#020817]
                            p-16
                            text-center
                        "
                    >
                        <div class="text-5xl mb-4">
                            🗑️
                        </div>

                        <h2
                            class="
                                text-xl
                                font-bold
                                text-slate-700
                                dark:text-slate-200
                            "
                        >
                            No hay documentos eliminados
                        </h2>

                        <p
                            class="
                                mt-2
                                text-sm
                                text-slate-500
                                dark:text-slate-400
                            "
                        >
                            Los documentos eliminados aparecerán aquí.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>

        /*
        |--------------------------------------------------------------------------
        | MENÚ DE PAPELERA
        |--------------------------------------------------------------------------
        */

        window.toggleTrashMenu = function (event, categoryId) {
            event.stopPropagation();
            const menu = document.getElementById(
                `trash-menu-${categoryId}`
            );

            if (!menu) {
                return;
            }

            // Cerrar todos los demás menús
            document
                .querySelectorAll('[id^="trash-menu-"]')
                .forEach(otherMenu => {

                    if (otherMenu !== menu) {

                        otherMenu.classList.add('hidden');

                    }

                });


            // Abrir / cerrar el menú seleccionado
            menu.classList.toggle('hidden');

        };

        /*
        |--------------------------------------------------------------------------
        | ABRIR MODAL DE RESTAURACIÓN
        |--------------------------------------------------------------------------
        */
        window.openCategoryRestoreModal = function (
            event,
            categoryId,
            categoryName
        ) {

            event.stopPropagation();

            const modal = document.getElementById(
                'category-restore-modal'
            );

            const form = document.getElementById(
                'category-restore-form'
            );

            const categoryNameElement = document.getElementById(
                'category-restore-name'
            );


            if (!modal || !form || !categoryNameElement) {
                return;
            }

            // Mostrar nombre
            categoryNameElement.textContent = categoryName;

            // Configurar formulario
            form.action = `/documentacion/${categoryId}/restore`;

            // Mostrar modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');

        };
        /*
        |--------------------------------------------------------------------------
        | CERRAR MODAL DE RESTAURACIÓN
        |--------------------------------------------------------------------------
        */
        window.closeCategoryRestoreModal = function () {

            const modal = document.getElementById(
                'category-restore-modal'
            );

            if (!modal) {
                return;
            }
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        window.openCategoryPermanentDeleteModal = function (
            event,
            categoryId,
            categoryName
        ) {
            event.stopPropagation();
            const modal = document.getElementById(
                'category-permanent-delete-modal'
            );
            const form = document.getElementById(
                'category-permanent-delete-form'
            );
            const categoryNameElement = document.getElementById(
                'category-permanent-delete-name'
            );
            if (!modal || !form || !categoryNameElement) {
                return;
            }
            // Mostrar nombre
            categoryNameElement.textContent = categoryName;

            // Configurar formulario
            form.action = `/documentacion/${categoryId}/permanent-delete`;

            // Mostrar modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        };

        window.closeCategoryPermanentDeleteModal = function () {
            const modal = document.getElementById(
                'category-permanent-delete-modal'
            );

            if (!modal) {
                return;
            }
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        /*
        |--------------------------------------------------------------------------
        | CLIC GLOBAL
        |--------------------------------------------------------------------------
        */
        document.addEventListener('click', function (event) {
            /*
            |--------------------------------------------------------------------------
            | CERRAR MENÚ DE PAPELERA
            |--------------------------------------------------------------------------
            */
            const clickedTrashButton =
                event.target.closest(
                    '[onclick^="toggleTrashMenu"]'
                );
            const clickedTrashMenu =
                event.target.closest(
                    '[id^="trash-menu-"]'
                );
            if (!clickedTrashButton && !clickedTrashMenu) {
                document
                    .querySelectorAll('[id^="trash-menu-"]')
                    .forEach(menu => {
                        menu.classList.add('hidden');
                    });
            }

            /*
            |--------------------------------------------------------------------------
            | CERRAR MODAL CON X
            |--------------------------------------------------------------------------
            */
            if (
                event.target.closest(
                    '#close-category-restore-modal'
                )
            ) {
                closeCategoryRestoreModal();
                return;
            }
            /*
            |--------------------------------------------------------------------------
            | CERRAR MODAL CON CANCELAR
            |--------------------------------------------------------------------------
            */
            if (
                event.target.closest(
                    '#cancel-category-restore-modal'
                )
            ) {
                closeCategoryRestoreModal();
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | CERRAR MODAL HACIENDO CLICK FUERA
            |--------------------------------------------------------------------------
            */
            const restoreModal =
                document.getElementById(
                    'category-restore-modal'
                );

                if (
                    restoreModal &&
                    event.target === restoreModal
                ) {
                    closeCategoryRestoreModal();
                    return;
                }
            /*
            |--------------------------------------------------------------------------
            | CERRAR MODAL DE ELIMINACIÓN DEFINITIVA CON X
            |--------------------------------------------------------------------------
            */

            if (
                event.target.closest(
                    '#close-category-permanent-delete-modal'
                )
            ) {
                closeCategoryPermanentDeleteModal();
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | CERRAR MODAL DE ELIMINACIÓN DEFINITIVA CON CANCELAR
            |--------------------------------------------------------------------------
            */

            if (
                event.target.closest(
                    '#cancel-category-permanent-delete-modal'
                )
            ) {
                closeCategoryPermanentDeleteModal();
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | CERRAR MODAL HACIENDO CLICK FUERA
            |--------------------------------------------------------------------------
            */
            const permanentDeleteModal =
                document.getElementById(
                    'category-permanent-delete-modal'
                );

            if (
                permanentDeleteModal &&
                event.target === permanentDeleteModal
            ) {
                closeCategoryPermanentDeleteModal();
                return;
            }
        });
    </script>
@include('documentacion.partials.category-restore-modal')
@include('documentacion.partials.category-permanent-delete-modal')
</x-app-layout>