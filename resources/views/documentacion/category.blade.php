<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- ENCABEZADO --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    {{-- VOLVER --}}
                    <a
                        href="{{ route('documentacion.index') }}"
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
                            src="{{ asset('images/documentacion/atras.png') }}"
                            alt="Volver"
                            class="w-5 h-5 object-contain"
                        >
                        <span>
                            Volver a documentación
                        </span>
                    </a>
                    {{-- CATEGORÍA --}}
                    <div class="flex items-center gap-4">
                        {{-- IMAGEN DE CATEGORÍA --}}
                        <div class="
                            w-16
                            h-16
                            rounded-2xl
                            bg-slate-100
                            dark:bg-slate-900
                            flex
                            items-center
                            justify-center
                            overflow-hidden
                            flex-shrink-0
                        " >
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
                                    class="w-full h-full object-contain p-3"
                                >
                            @endif
                        </div>
                        <div>
                            <h1 class="
                                text-2xl
                                font-bold
                                text-slate-800
                                dark:text-white
                            ">
                                {{ $category->name }}
                            </h1>
                            @if($category->description)
                                <p class="
                                    mt-1
                                    text-sm
                                    text-slate-500
                                    dark:text-slate-400
                                ">
                                    {{ $category->description }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                {{--Botones --}}
                <div class="flex items-center gap-3">
                    {{-- NUEVA SUBCARPETA --}}
                    <button
                        type="button"
                        id="open-subcategory-modal"
                        class="
                            inline-flex
                            items-center
                            gap-2
                            rounded-xl
                            bg-slate-700
                            hover:bg-slate-600
                            px-4
                            py-2.5
                            text-sm
                            font-semibold
                            text-white
                            transition
                        "
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>

                        <span>
                            Crear Nueva carpeta
                        </span>
                    </button>

                    {{-- SUBIR ARCHIVO --}}
                    <button
                        type="button"
                        id="open-document-upload-modal"
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
                            src="{{ asset('images/documentacion/nuevo.png') }}"
                            alt="Subir"
                            class="w-5 h-5 object-contain"
                        >
                        <span>
                            Subir archivo
                        </span>
                    </button>

                    {{-- SUBIR CARPETA --}}
                    <button
                        type="button"
                        id="open-folder-upload-modal"
                        class="
                            inline-flex
                            items-center
                            gap-2
                            rounded-xl
                            bg-emerald-600
                            hover:bg-emerald-700
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
                            alt="Subir carpeta"
                            class="w-5 h-5 object-contain"
                        >
                        <span>
                            Subir carpeta
                        </span>
                    </button>
                </div>
            </div>
            
            {{-- INFORMACIÓN Y BÚSQUEDA --}}
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
                <div
                    class="
                        flex
                        flex-col
                        md:flex-row
                        md:items-center
                        md:justify-between
                        gap-4
                    "
                >
                    <div>
                        <p
                            class="
                                text-sm
                                font-semibold
                                text-slate-700
                                dark:text-slate-200
                            "
                        >
                            Documentos
                        </p>

                        <p
                            class="
                                mt-1
                                text-xs
                                text-slate-500
                                dark:text-slate-400
                            "
                        >
                            Archivos almacenados en esta categoría.
                        </p>
                    </div>
                    <div
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
                        {{ $documents->count() }}
                    </div>
                </div>
                {{-- BUSCADOR --}}
                @if($documents->count())
                    <div class="mt-4">
                        <div class="relative">
                            <span
                                class="
                                    absolute
                                    inset-y-0
                                    left-0
                                    flex
                                    items-center
                                    pl-4
                                    text-slate-400
                                "
                            >
                                🔎
                            </span>
                            <form
                                method="GET"
                                action="{{ route('documentacion.category', $category) }}"
                                class="mt-4"
                            >
                                <div class="relative">
                                    <span
                                        class="
                                            absolute
                                            inset-y-0
                                            left-0
                                            flex
                                            items-center
                                            pl-4
                                            text-slate-400
                                        "
                                    >
                                        🔎
                                    </span>
                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="Buscar documentos..."
                                        class="
                                            w-full
                                            rounded-xl
                                            border
                                            border-slate-300
                                            dark:border-slate-700
                                            bg-slate-50
                                            dark:bg-slate-900
                                            text-sm
                                            text-slate-700
                                            dark:text-slate-200
                                            placeholder-slate-400
                                            pl-11
                                            pr-4
                                            py-3
                                            outline-none
                                            focus:border-blue-500
                                            focus:ring-2
                                            focus:ring-blue-500/20
                                            transition
                                        "
                                    >
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
            {{-- Acciones--}}

            {{-- SUBCARPETAS --}}
            @if($subcategories->count())

                <div class="mb-6">

                    {{-- TÍTULO --}}
                    <div class="mb-3">

                        <p
                            class="
                                text-sm
                                font-semibold
                                text-slate-700
                                dark:text-slate-200
                            "
                        >
                            Carpetas
                        </p>

                        <p
                            class="
                                mt-1
                                text-xs
                                text-slate-500
                                dark:text-slate-400
                            "
                        >
                            Carpetas contenidas en esta categoría.
                        </p>

                    </div>


                    {{-- LISTA DE CARPETAS --}}
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
                        @foreach($subcategories as $subcategory)
                            <div
                                class="
                                    relative
                                    group
                                    flex
                                    items-center
                                    justify-between
                                    gap-4
                                    px-5
                                    py-4
                                    border-b
                                    border-slate-200
                                    dark:border-slate-800
                                    last:border-b-0
                                    hover:bg-slate-50
                                    dark:hover:bg-slate-900/60
                                    transition
                                "
                            >
                                {{-- CONTENIDO DE LA CARPETA --}}
                                <a
                                    href="{{ route('documentacion.category', $subcategory) }}"
                                    class="
                                        flex
                                        items-center
                                        gap-4
                                        min-w-0
                                        flex-1
                                    "
                                >
                                    {{-- ICONO --}}
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
                                            flex-shrink-0
                                            overflow-hidden
                                        "
                                    >
                                        @if($subcategory->image)
                                            <img
                                                src="{{ asset('storage/' . $subcategory->image) }}"
                                                alt="{{ $subcategory->name }}"
                                                class="w-full h-full object-contain p-1"
                                            >
                                        @else
                                            <img
                                                src="{{ asset('images/documentacion/default-category.png') }}"
                                                alt="Carpeta"
                                                class="w-full h-full object-contain p-2"
                                            >
                                        @endif
                                    </div>
                                    {{-- INFORMACIÓN --}}
                                    <div class="min-w-0">
                                        <p
                                            class="
                                                font-semibold
                                                text-slate-800
                                                dark:text-slate-200
                                                group-hover:text-blue-500
                                                transition
                                                truncate
                                            "
                                        >
                                            {{ $subcategory->name }}
                                        </p>
                                        @if($subcategory->description)
                                            <p
                                                class="
                                                    mt-1
                                                    text-xs
                                                    text-slate-500
                                                    dark:text-slate-400
                                                    truncate
                                                "
                                            >
                                                {{ $subcategory->description }}
                                            </p>
                                        @endif
                                        <p
                                            class="
                                                mt-1
                                                text-xs
                                                text-slate-500
                                                dark:text-slate-400
                                            "
                                        >
                                            {{ $subcategory->documents_count }}
                                            {{ $subcategory->documents_count == 1
                                                ? 'documento'
                                                : 'documentos'
                                            }}
                                        </p>

                                        @if($subcategory->last_activity)
                                            <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">
                                                Última modificación por
                                                <span class="font-medium text-slate-500 dark:text-slate-400">
                                                    {{ $subcategory->last_activity->user?->name ?? 'Usuario desconocido' }}
                                                </span>
                                                el
                                                {{ $subcategory->last_activity->created_at?->format('d/m/Y H:i') }}
                                            </p>
                                        @endif
                                    </div>
                                </a>
                                {{-- ACCIONES --}}
                                <div class="relative flex-shrink-0">
                                    {{-- BOTÓN ⋮ --}}
                                    <button
                                        type="button"
                                        class="
                                            w-9
                                            h-9
                                            rounded-lg
                                            flex
                                            items-center
                                            justify-center
                                            text-slate-400
                                            hover:text-slate-700
                                            hover:bg-slate-200
                                            dark:hover:text-slate-200
                                            dark:hover:bg-slate-800
                                            transition
                                        "
                                        onclick="toggleSubcategoryMenu(event, {{ $subcategory->id }})"
                                        title="Acciones"
                                    >
                                        ⋮
                                    </button>
                                    {{-- MENÚ --}}
                                    <div
                                        id="subcategory-menu-{{ $subcategory->id }}"
                                        class="
                                            hidden
                                            fixed
                                            z-[9999]
                                            z-30
                                            w-44
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
                                                py-2.5
                                                text-sm
                                                text-slate-700
                                                dark:text-slate-200
                                                hover:bg-slate-100
                                                dark:hover:bg-slate-800
                                                transition
                                            "
                                            onclick="openCategoryEditModal(
                                                event,
                                                {{ $subcategory->id }},
                                                @js($subcategory->name),
                                                @js($subcategory->description),
                                                @js($subcategory->image)
                                            )"
                                        >
                                            <span>✏️</span>
                                            <span>Editar</span>
                                        </button>
                                        {{-- MOVER --}}
                                        <button
                                            type="button"
                                            class="
                                                w-full
                                                flex
                                                items-center
                                                gap-3
                                                px-4
                                                py-2.5
                                                text-sm
                                                text-slate-700
                                                dark:text-slate-200
                                                hover:bg-slate-100
                                                dark:hover:bg-slate-800
                                                transition
                                            "
                                            onclick="openCategoryMoveModal(
                                                event,
                                                {{ $subcategory->id }},
                                                @js($subcategory->name)
                                            )"
                                        >
                                            <span>📂</span>
                                            <span>Mover</span>
                                        </button>
                                        {{-- SEPARADOR --}}
                                        <div
                                            class="
                                                border-t
                                                border-slate-200
                                                dark:border-slate-700
                                            "
                                        ></div>
                                        {{-- ELIMINAR --}}
                                        <button
                                            type="button"
                                            class="
                                                w-full
                                                flex
                                                items-center
                                                gap-3
                                                px-4
                                                py-2.5
                                                text-sm
                                                text-red-600
                                                hover:bg-red-50
                                                dark:text-red-400
                                                dark:hover:bg-red-950/30
                                                transition
                                            "
                                            onclick="openCategoryDeleteModal(
                                                event,
                                                {{ $subcategory->id }},
                                                @js($subcategory->name)
                                            )"
                                        >
                                            <span>🗑️</span>
                                            <span>Eliminar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            {{-- LISTADO DE DOCUMENTOS --}}
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
                        @php
                            $extension = strtolower(
                                pathinfo($document->file_name, PATHINFO_EXTENSION)
                            );
                            $icon = match ($extension) {
                                'xls', 'xlsx', 'csv'
                                    => asset('images/documentacion/excel.png'),
                                'pdf'
                                    => asset('images/documentacion/pdf.png'),
                                'ppt', 'pptx'
                                    => asset('images/documentacion/powerpoint.png'),
                                'doc', 'docx'
                                    => asset('images/documentacion/word.png'),
                                'sql'
                                    => asset('images/documentacion/sql.png'),
                                'txt'
                                    => asset('images/documentacion/txt.png'),
                                'rar', 'zip'
                                    => asset('images/documentacion/rar.png'),
                                'jpg', 'jpeg', 'png', 'gif', 'webp'
                                    => asset('images/documentacion/imagen.png'),
                                'xml', 'xml'
                                    => asset('images/documentacion/xml.png'),
                                default
                                    => asset('images/documentacion/txt.png'),
                            };
                            if ($document->file_size >= 1024 * 1024) {
                                $fileSize = number_format(
                                    $document->file_size / 1024 / 1024,
                                    2
                                ) . ' MB';
                            } else {
                                $fileSize = number_format(
                                    $document->file_size / 1024,
                                    2
                                ) . ' KB';
                            }
                        @endphp
                        <div
                            class="
                                document-item
                                flex
                                items-center
                                gap-4
                                px-5
                                py-4
                                border-b
                                border-slate-200
                                dark:border-slate-800
                                last:border-b-0
                                hover:bg-slate-50
                                dark:hover:bg-slate-900/60
                                transition
                            "
                            data-search="
                                {{ strtolower(
                                    $document->name . ' ' .
                                    ($document->description ?? '') . ' ' .
                                    $document->file_name
                                ) }}
                            "
                        >
                            {{-- DOCUMENTO --}}
                            <a
                                href="{{ route('documentacion.documents.download', $document) }}"
                                class="
                                    flex
                                    items-center
                                    gap-4
                                    flex-1
                                    min-w-0
                                    group
                                "
                            >
                                {{-- ICONO --}}
                                <div
                                    class="
                                        w-14
                                        h-14
                                        rounded-xl
                                        bg-slate-100
                                        dark:bg-slate-900
                                        flex
                                        items-center
                                        justify-center
                                        flex-shrink-0
                                        overflow-hidden
                                        border
                                        border-slate-200
                                        dark:border-slate-800
                                    "
                                >
                                    <img
                                        src="{{ $icon }}"
                                        alt="{{ strtoupper($extension) }}"
                                        class="
                                            w-full
                                            h-full
                                            object-contain
                                            p-2
                                        "
                                    >
                                </div>
                                {{-- INFORMACIÓN --}}
                                <div class="flex-1 min-w-0">
                                    {{-- NOMBRE --}}
                                    <h2
                                        class="
                                            text-sm
                                            font-bold
                                            text-slate-700
                                            dark:text-slate-200
                                            truncate
                                            group-hover:text-blue-600
                                            dark:group-hover:text-blue-400
                                            transition
                                        "
                                    >
                                        {{ $document->name }}
                                    </h2>
                                    {{-- DESCRIPCIÓN --}}
                                    @if($document->description)
                                        <p
                                            class="
                                                mt-1
                                                text-sm
                                                text-slate-500
                                                dark:text-slate-400
                                                truncate
                                            "
                                        >
                                            {{ $document->description }}
                                        </p>
                                    @else
                                        <P
                                            class="
                                                mt-1
                                                text-sm
                                                italic
                                                text-slate-400
                                                dark:text-slate-500
                                            "
                                        >
                                            Sin descripción
                                        </p>

                                    @endif
                                    {{-- METADATOS --}}
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
                                            {{ strtoupper($extension) }}
                                        </span>
                                        <span>•</span>
                                        <span>
                                            {{ $fileSize }}
                                        </span>
                                        <span>•</span>
                                        <span>
                                            {{ $document->created_at->format('d/m/Y H:i') }}
                                        </span>
                                        <span>•</span>
                                        <span>
                                            Subido por {{ $document->creator->name ?? 'Usuario desconocido' }}
                                        </span>
                                        <span>•</span>
                                        @if($document->last_activity)
                                            <span>
                                                Última modificación por
                                                {{ $document->last_activity->user?->name ?? 'Usuario desconocido' }}
                                            </span>
                                            <span>el</span>
                                            <span>
                                                {{ $document->last_activity->created_at?->format('d/m/Y H:i') }}
                                            </span>
                                        @else
                                            <span>
                                                No ha sido modificado aún
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            {{-- ACCIONES --}}
                            <div
                                class="
                                    flex
                                    items-center
                                    gap-2
                                    flex-shrink-0
                                "
                            >
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
                                        hover:text-blue-500
                                        hover:bg-blue-50
                                        dark:hover:bg-blue-950/30
                                        transition
                                    "
                                    title="Editar"
                                    data-document-id="{{ $document->id }}"
                                    data-document-name="{{ $document->name }}"
                                    data-document-description="{{ $document->description }}"
                                    data-document-file-name="{{ $document->file_name }}"
                                    data-document-extension="{{ strtolower($document->file_type) }}"
                                    onclick="openDocumentEditModal(this)"
                                >
                                    <img
                                        src="{{ asset('images/documentacion/editar.png') }}"
                                        alt="editar"
                                        class="w-6 h-6 object-contain"
                                    >
                                </button>
                                {{-- MOVER --}}
                                <button
                                    type="button"
                                    title="Mover documento"
                                    class="w-10 h-10 rounded-xl flex items-center justify-center hover:bg-amber-50 dark:hover:bg-amber-950/30 transition"
                                    data-document-id="{{ $document->id }}"
                                    data-document-name="{{ $document->name }}"
                                    onclick="openDocumentMoveModal(this)"
                                >
                                    <img
                                        src="{{ asset('images/documentacion/carpeta.png') }}"
                                        alt="Mover"
                                        class="w-6 h-6 object-contain"
                                    >
                                </button>
                                {{-- DESCARGAR --}}
                                <a
                                    href="{{ route('documentacion.documents.download', $document) }}"
                                    title="Descargar documento"
                                    class="
                                        w-10
                                        h-10
                                        rounded-xl
                                        flex
                                        items-center
                                        justify-center
                                        hover:bg-blue-50
                                        dark:hover:bg-blue-950/30
                                        transition
                                    "
                                >
                                   <img
                                        src="{{ asset('images/documentacion/descargar.png') }}"
                                        alt="Descargar"
                                        class="w-6 h-6 object-contain"
                                    >
                                </a>
                                {{-- ELIMINAR --}}
                                <button
                                    type="button"
                                    title="Eliminar documento"
                                    class="
                                        w-10
                                        h-10
                                        rounded-xl
                                        flex
                                        items-center
                                        justify-center
                                        hover:bg-red-50
                                        dark:hover:bg-red-950/30
                                        transition
                                    "
                                    data-document-id="{{ $document->id }}"
                                    data-document-name="{{ $document->name }}"
                                    data-document-file-name="{{ $document->file_name }}"
                                    data-document-extension="{{ strtolower($document->file_type) }}"
                                    onclick="openDocumentDeleteModal(this)"
                                >

                                    <img
                                        src="{{ asset('images/documentacion/basurero.png') }}"
                                        alt="Eliminar"
                                        class="w-6 h-6 object-contain"
                                    >
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- PAGINACIÓN --}}
                @if($documents->hasPages())
                    <div class="mt-6">
                        {{ $documents->links() }}
                    </div>
                @endif
            @elseif(!$subcategories->count())
                {{-- SIN DOCUMENTOS NI SUBCARPETAS --}}
                <div class="rounded-2xl border border-dashed border-slate-300 dark:border-slate-700 bg-white dark:bg-[#020817] px-6 py-12 text-center">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-900 flex items-center justify-center">
                        <svg
                            class="w-8 h-8 text-slate-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M9 13h6m-3-3v6m-7 5h10a2 2 0 002-2V7.828a2 2 0 00-.586-1.414l-3.828-3.828A2 2 0 0011.172 2H5a2 2 0 00-2 2v14a2 2 0 002 2z"
                            />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-slate-700 dark:text-slate-200">
                        No hay documentos
                    </h2>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                        Esta categoría todavía no contiene documentos ni subcarpetas.
                    </p>
                    @if(auth()->user()->can('create', App\Models\Document::class))
                        <a
                            href="{{ route('documentacion.create', ['category_id' => $category->id]) }}"
                            class="inline-flex items-center gap-2 mt-6 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>
                            Subir documento
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- OVERLAY DRAG & DROP --}}
    <div
        id="document-drag-overlay"
        class="
            hidden
            fixed
            inset-0
            z-[60]
            bg-blue-600/20
            backdrop-blur-sm
            items-center
            justify-center
            pointer-events-none
        "
    >
        <div
            class="
                w-full
                max-w-xl
                mx-6
                rounded-3xl
                border-2
                border-dashed
                border-blue-500
                bg-slate-950/90
                px-10
                py-14
                text-center
                shadow-2xl
            "
        >
            <div class="text-6xl mb-5">
                📎
            </div>
            <h2
                class="
                    text-2xl
                    font-bold
                    text-white
                "
            >
                Suelta tus archivos aquí
            </h2>
            <p
                class="
                    mt-2
                    text-sm
                    text-slate-300
                "
            >
                El cargador de documentos se abrirá automáticamente.
            </p>
        </div>
    </div>

    @include('documentacion.partials.category-subcategory-modal', ['category' => $category])
    @include('documentacion.partials.document-upload-modal', ['category' => $category])
    @include('documentacion.partials.document-edit-modal')
    @include('documentacion.partials.document-delete-modal')

    @include('documentacion.partials.category-edit-modal')
    @include('documentacion.partials.category-delete-modal')
    @include('documentacion.partials.category-move-modal')
    @include('documentacion.partials.document-move-modal')

    @include('documentacion.partials.document-folder-upload-modal', [
        'parentCategoryId' => $category->id,
    ])
    
    <script>
        /*
        |--------------------------------------------------------------------------
        | MODAL NUEVA SUBCARPETA
        |--------------------------------------------------------------------------
        */

        const subcategoryModal = document.getElementById('subcategory-modal');
        const openSubcategoryButton = document.getElementById('open-subcategory-modal');
        const closeSubcategoryButton = document.getElementById('close-subcategory-modal');
        const cancelSubcategoryButton = document.getElementById('cancel-subcategory-modal');

        /*
        |--------------------------------------------------------------------------
        | ABRIR MODAL
        |--------------------------------------------------------------------------
        */

        function openSubcategoryModal() {
            if (!subcategoryModal) {
                return;
            }
            subcategoryModal.classList.remove('hidden');
            subcategoryModal.classList.add('flex');
            const nameInput = document.getElementById('subcategory-name');
            
            if (nameInput) {
                setTimeout(() => {
                    nameInput.focus();
                }, 100);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | MENÚ DE SUBCARPETAS
        |--------------------------------------------------------------------------
        */

        window.toggleSubcategoryMenu = function (event, subcategoryId) {
            event.stopPropagation();
            
            const menu = document.getElementById(`subcategory-menu-${subcategoryId}`);

            if (!menu) {
                return;
            }
            // Cerrar otros menús
            document
                .querySelectorAll('[id^="subcategory-menu-"]')
                .forEach(otherMenu => {

                    if (otherMenu !== menu) {
                        otherMenu.classList.add('hidden');
                    }

                });

            // Si ya estaba abierto, cerrarlo
            if (!menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                return;
            }

            // Mostrar temporalmente para obtener dimensiones
            menu.classList.remove('hidden');

            const button = event.currentTarget;
            const buttonRect = button.getBoundingClientRect();
            const menuWidth = menu.offsetWidth;
            const menuHeight = menu.offsetHeight;
            const spacing = 8;

            /*
            |--------------------------------------------------------------------------
            | POSICIÓN HORIZONTAL
            |--------------------------------------------------------------------------
            */
            let left =
                buttonRect.right - menuWidth;
            /*
            |--------------------------------------------------------------------------
            | POSICIÓN VERTICAL
            |--------------------------------------------------------------------------
            */
            let top =
                buttonRect.bottom + spacing;
            /*
            |--------------------------------------------------------------------------
            | SI NO CABE ABAJO → ABRIR HACIA ARRIBA
            |--------------------------------------------------------------------------
            */
            if (
                top + menuHeight >
                window.innerHeight - spacing
            ) {
                top =
                    buttonRect.top -
                    menuHeight -
                    spacing;
            }

            /*
            |--------------------------------------------------------------------------
            | EVITAR QUE SE SALGA POR LA IZQUIERDA
            |--------------------------------------------------------------------------
            */

            if (left < spacing) {
                left = spacing;
            }

            /*
            |--------------------------------------------------------------------------
            | EVITAR QUE SE SALGA POR LA DERECHA
            |--------------------------------------------------------------------------
            */

            if (
                left + menuWidth >
                window.innerWidth - spacing
            ) {
                left =
                    window.innerWidth -
                    menuWidth -
                    spacing;
            }
            menu.style.left = `${left}px`;
            menu.style.top = `${top}px`;
        };

        /*
        |--------------------------------------------------------------------------
        | ABRIR MODAL DE EDICIÓN DE SUBCARPETA
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
            
            const modal = document.getElementById('category-edit-modal');
            const form = document.getElementById('category-edit-form');
            const nameInput = document.getElementById('edit-category-name');
            const descriptionInput = document.getElementById('edit-category-description');
            const imagePreview = document.getElementById('edit-category-image-preview');
            const removeImageContainer = document.getElementById('remove-category-image-container');
            const removeImageCheckbox = document.getElementById('remove-category-image');

            if (!modal || !form) {
                return;
            }

            // Cargar nombre
            nameInput.value = categoryName ?? '';

            // Cargar descripción
            descriptionInput.value =
                categoryDescription ?? '';

            // Configurar URL
            form.action =
                `/documentacion/${categoryId}`;

            // Cargar imagen
            if (categoryImage) {
                imagePreview.src =
                    `/storage/${categoryImage}`;
                removeImageContainer.classList.remove(
                    'hidden'
                );
            } else {
                imagePreview.src =
                    '/images/documentacion/default-category.png';
                removeImageContainer.classList.add(
                    'hidden'
                );
            }

            // Reiniciar checkbox
            if (removeImageCheckbox) {
                removeImageCheckbox.checked = false;
            }

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
            
            const modal = document.getElementById('category-edit-modal');
            const imageInput = document.getElementById('edit-category-image');
            const removeImageCheckbox = document.getElementById('remove-category-image');

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
        /*
        | ======================================================
        | MODAL MOVER CATEGORÍA
        | =====================================================
        */

        window.openCategoryMoveModal = async function (
            event,
            categoryId,
            categoryName
        ) {
            event.stopPropagation();

            const modal = document.getElementById('category-move-modal');
            const form = document.getElementById('category-move-form');
            const nameElement = document.getElementById('category-move-name');
            const parentSelect = document.getElementById('category-move-parent');
            const loading = document.getElementById('category-move-loading');
            const error = document.getElementById('category-move-error');
            const submitButton = document.getElementById('submit-category-move');

            if (!modal || !form || !parentSelect) return;

            // Nombre de la carpeta
            if (nameElement) {
                nameElement.textContent = categoryName ?? '';
            }

            // Configurar URL del formulario
            form.action = `/documentacion/${categoryId}/move`;

            // Limpiar estado anterior
            parentSelect.innerHTML = '';

            if (loading) {
                loading.classList.remove('hidden');
            }

            if (error) {
                error.classList.add('hidden');
                error.textContent = '';
            }

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            }

            // Mostrar modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            try {
                const response = await fetch(
                    `/documentacion/${categoryId}/move-targets`,
                    {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                );

                if (!response.ok) {
                    throw new Error('No se pudieron cargar las carpetas.');
                }

                const data = await response.json();
                parentSelect.innerHTML = '';

                /*
                |--------------------------------------------------------------------------
                | CARPETA RAÍZ
                |--------------------------------------------------------------------------
                */
                if (!data.is_root) {
                    const rootOption = document.createElement('option');
                    rootOption.value = '';
                    rootOption.textContent = '📁 Carpeta Raíz / Sin carpeta';
                    parentSelect.appendChild(rootOption);
                }

                /*
                |--------------------------------------------------------------------------
                | CARPETAS DISPONIBLES
                |--------------------------------------------------------------------------
                */

                if (Array.isArray(data.targets)) {
                    data.targets.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = `📁 ${category.name}`;
                        parentSelect.appendChild(option);
                    });
                }

                if (loading) {
                    loading.classList.add('hidden');
                }

                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.classList.remove(
                        'opacity-50',
                        'cursor-not-allowed'
                    );
                }

            } catch (err) {
                console.error('Error cargando destinos:', err);
                if (loading) {
                    loading.classList.add('hidden');
                }
                if (error) {
                    error.textContent =
                        'No se pudieron cargar las carpetas disponibles.';
                    error.classList.remove('hidden');
                }
            }
        };
        window.closeCategoryMoveModal = function () {
            const modal = document.getElementById('category-move-modal');
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('category-move-modal');
            const closeButton = document.getElementById('close-category-move-modal');
            const cancelButton = document.getElementById('cancel-category-move-modal');

            if (!modal) return;

            // Botón X
            if (closeButton) {
                closeButton.addEventListener('click', function () {
                    window.closeCategoryMoveModal();
                });
            }

            // Botón Cancelar
            if (cancelButton) {
                cancelButton.addEventListener('click', function () {
                    window.closeCategoryMoveModal();
                });
            }

            // Click fuera del modal
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    window.closeCategoryMoveModal();
                }
            });

            // ESC
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    window.closeCategoryMoveModal();
                }
            });
        });

        /*
        |--------------------------------------------------------------------------
        | ABRIR MODAL DE ELIMINACIÓN
        |--------------------------------------------------------------------------
        */

        window.openCategoryDeleteModal = function (
            event,
            categoryId,
            categoryName
        ) {

            event.stopPropagation();
            
            const modal = document.getElementById('category-delete-modal');
            const form = document.getElementById('category-delete-form');
            const categoryNameElement = document.getElementById('category-delete-name');

            if (!modal || !form) {
                return;
            }

            // Mostrar nombre de la categoría
            if (categoryNameElement) {
                categoryNameElement.textContent =
                    categoryName ?? '';
            }

            // Configurar URL del formulario
            form.action =
                `/documentacion/${categoryId}`;

            // Mostrar modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        };

        /*
        |--------------------------------------------------------------------------
        | CERRAR MODAL DE ELIMINACIÓN
        |--------------------------------------------------------------------------
        */

        window.closeCategoryDeleteModal = function () {
            const modal = document.getElementById('category-delete-modal');
            if (!modal) {
                return;
            }
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        /*
        |--------------------------------------------------------------------------
        | BOTONES DE CIERRE - ELIMINAR
        |--------------------------------------------------------------------------
        */
    
        const closeCategoryDeleteButton = document.getElementById('close-category-delete-modal');
        const cancelCategoryDeleteButton = document.getElementById('cancel-category-delete-modal');
        const categoryDeleteModal = document.getElementById('category-delete-modal');
   
        /*
        |--------------------------------------------------------------------------
        | BOTÓN X
        |--------------------------------------------------------------------------
        */

        if (closeCategoryDeleteButton) {
            closeCategoryDeleteButton.addEventListener(
                'click',
                function () {
                    closeCategoryDeleteModal();
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BOTÓN CANCELAR
        |--------------------------------------------------------------------------
        */

        if (cancelCategoryDeleteButton) {
            cancelCategoryDeleteButton.addEventListener(
                'click',
                function () {
                    closeCategoryDeleteModal();
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CLICK FUERA
        |--------------------------------------------------------------------------
        */

        if (categoryDeleteModal) {
            categoryDeleteModal.addEventListener(
                'click',
                function (event) {
                    if (
                        event.target ===
                        categoryDeleteModal
                    ) {
                        closeCategoryDeleteModal();
                    }
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ESC
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'keydown',
            function (event) {
                if (
                    event.key === 'Escape' &&
                    categoryDeleteModal &&
                    !categoryDeleteModal.classList.contains(
                        'hidden'
                    )
                ) {
                    closeCategoryDeleteModal();
                }
            }
        );

        /*
        |--------------------------------------------------------------------------
        | BOTONES DE CIERRE
        |--------------------------------------------------------------------------
        */

        const closeCategoryEditButton = document.getElementById('close-category-edit-modal');
        const cancelCategoryEditButton = document.getElementById('cancel-category-edit-modal');
        const categoryEditModal = document.getElementById('category-edit-modal');

        /*
        |--------------------------------------------------------------------------
        | BOTÓN X
        |--------------------------------------------------------------------------
        */

        if (closeCategoryEditButton) {
            closeCategoryEditButton.addEventListener(
                'click',
                function () {
                    closeCategoryEditModal();
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BOTÓN CANCELAR
        |--------------------------------------------------------------------------
        */

        if (cancelCategoryEditButton) {
            cancelCategoryEditButton.addEventListener(
                'click',
                function () {
                    closeCategoryEditModal();
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CLICK FUERA DEL MODAL
        |--------------------------------------------------------------------------
        */

        if (categoryEditModal) {
            categoryEditModal.addEventListener(
                'click',
                function (event) {
                    if (
                        event.target ===
                        categoryEditModal
                    ) {
                        closeCategoryEditModal();
                    }
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ESC
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'keydown',
            function (event) {
                if (
                    event.key === 'Escape' &&
                    categoryEditModal &&
                    !categoryEditModal.classList.contains(
                        'hidden'
                    )
                ) {
                    closeCategoryEditModal();
                }
            }
        );
        /*
        |--------------------------------------------------------------------------
        | CERRAR MODAL
        |--------------------------------------------------------------------------
        */

        function closeSubcategoryModal() {
            if (!subcategoryModal) {
                return;
            }
            subcategoryModal.classList.add('hidden');
            subcategoryModal.classList.remove('flex');
        }

        /*
        |--------------------------------------------------------------------------
        | CERRAR MENÚS AL HACER CLICK AFUERA
        |--------------------------------------------------------------------------
        */

        document.addEventListener('click', function () {
            document
                .querySelectorAll('[id^="subcategory-menu-"]')
                .forEach(menu => {
                    menu.classList.add('hidden');
                });
        });

        /*
        |--------------------------------------------------------------------------
        | BOTÓN NUEVA SUBCARPETA
        |--------------------------------------------------------------------------
        */

        if (openSubcategoryButton) {
            openSubcategoryButton.addEventListener(
                'click',
                openSubcategoryModal
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BOTÓN X
        |--------------------------------------------------------------------------
        */

        if (closeSubcategoryButton) {
            closeSubcategoryButton.addEventListener(
                'click',
                closeSubcategoryModal
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BOTÓN CANCELAR
        |--------------------------------------------------------------------------
        */

        if (cancelSubcategoryButton) {
            cancelSubcategoryButton.addEventListener(
                'click',
                closeSubcategoryModal
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CERRAR HACIENDO CLICK FUERA
        |--------------------------------------------------------------------------
        */

        if (subcategoryModal) {
            subcategoryModal.addEventListener(
                'click',
                function (event) {
                    if (event.target === subcategoryModal) {
                        closeSubcategoryModal();
                    }
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CERRAR CON ESC
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'keydown',
            function (event) {
                if (
                    event.key === 'Escape' &&
                    subcategoryModal &&
                    !subcategoryModal.classList.contains('hidden')
                ) {
                    closeSubcategoryModal();
                }
            }
        );
    </script>
    <script>

        const documentStoreUrl = @json(route('documentacion.documents.store', $category));
        const documentCsrfToken = @json(csrf_token());

    </script>
    <script>
        /*
        |--------------------------------------------------------------------------
        | MODAL SUBIR DOCUMENTOS
        |--------------------------------------------------------------------------
        */

        const uploadModal = document.getElementById('document-upload-modal');
        const editDocumentFileIcon = document.getElementById('edit-document-file-icon');
        const deleteDocumentFileIcon = document.getElementById('delete-document-file-icon');
        const openUploadButton = document.getElementById('open-document-upload-modal');
        const openUploadEmptyButton = document.getElementById('open-document-upload-modal-empty');
        const closeUploadButton = document.getElementById('close-document-upload-modal');
        const cancelUploadButton = document.getElementById('cancel-document-upload-modal');
        const submitUploadButton = document.getElementById('submit-document-upload');

        /*
        |--------------------------------------------------------------------------
        | ARCHIVOS
        |--------------------------------------------------------------------------
        */

        const documentFileInput = document.getElementById('document-file');
        const documentFileList = document.getElementById('document-file-list');
        const selectedCount = document.getElementById('document-selected-count');
        const selectedCountNumber = document.getElementById('document-selected-count-number');

        /*
        |--------------------------------------------------------------------------
        | ARCHIVOS SELECCIONADOS
        |--------------------------------------------------------------------------
        */
        let selectedFiles = [];
        //creación de lote de archivos para subirlos de 15 en 15
        const BATCH_SIZE = 15;
        /*
        |--------------------------------------------------------------------------
        | ABRIR MODAL
        |--------------------------------------------------------------------------
        */
        function openDocumentUploadModal() {
            if (!uploadModal) {
                return;
            }
            uploadModal.classList.remove('hidden');
            uploadModal.classList.add('flex');
        }
        /*
        |--------------------------------------------------------------------------
        | CERRAR MODAL
        |--------------------------------------------------------------------------
        */
        function closeDocumentUploadModal() {
            if (!uploadModal) {
                return;
            }
            uploadModal.classList.add('hidden');
            uploadModal.classList.remove('flex');
        }
        /*
        |--------------------------------------------------------------------------
        | BOTÓN SUBIR ARCHIVO
        |--------------------------------------------------------------------------
        */
        if (openUploadButton) {
            openUploadButton.addEventListener(
                'click',
                openDocumentUploadModal
            );
        }
        /*
        |--------------------------------------------------------------------------
        | BOTÓN SUBIR PRIMER ARCHIVO
        |--------------------------------------------------------------------------
        */
        if (openUploadEmptyButton) {
            openUploadEmptyButton.addEventListener(
                'click',
                openDocumentUploadModal
            );
        }
        /*
        |--------------------------------------------------------------------------
        | BOTÓN X
        |--------------------------------------------------------------------------
        */
        if (closeUploadButton) {
            closeUploadButton.addEventListener(
                'click',
                closeDocumentUploadModal
            );
        }
        /*
        |--------------------------------------------------------------------------
        | BOTÓN CANCELAR
        |--------------------------------------------------------------------------
        */
        if (cancelUploadButton) {
            cancelUploadButton.addEventListener(
                'click',
                closeDocumentUploadModal
            );
        }
        /*
        |--------------------------------------------------------------------------
        | CERRAR HACIENDO CLICK FUERA
        |--------------------------------------------------------------------------
        */
        if (uploadModal) {
            uploadModal.addEventListener(
                'click',
                function (event) {
                    if (event.target === uploadModal) {
                        closeDocumentUploadModal();
                    }
                }
            );
        }
        /*
        |--------------------------------------------------------------------------
        | ICONO SEGÚN EXTENSIÓN
        |--------------------------------------------------------------------------
        */
        function getDocumentIcon(extension) {
            extension = extension.toLowerCase();
            const icons = {
                // Excel
                'xls': '/images/documentacion/excel.png',
                'xlsx': '/images/documentacion/excel.png',
                'csv': '/images/documentacion/excel.png',
                // PDF
                'pdf': '/images/documentacion/pdf.png',
                // PowerPoint
                'ppt': '/images/documentacion/powerpoint.png',
                'pptx': '/images/documentacion/powerpoint.png',
                // Word
                'doc': '/images/documentacion/word.png',
                'docx': '/images/documentacion/word.png',
                // SQL
                'sql': '/images/documentacion/sql.png',
                // TXT
                'txt': '/images/documentacion/txt.png',
                // RAR / ZIP
                'rar': '/images/documentacion/rar.png',
                'zip': '/images/documentacion/rar.png',
                // Imágenes
                'jpg': '/images/documentacion/imagen.png',
                'jpeg': '/images/documentacion/imagen.png',
                'png': '/images/documentacion/imagen.png',
                'gif': '/images/documentacion/imagen.png',
                'webp': '/images/documentacion/imagen.png',
                // archivos XML
                'xml': '/images/documentacion/xml.png',
            };
            return icons[extension]
                ?? '/images/documentacion/txt.png';
        }
        /*
        |--------------------------------------------------------------------------
        | FORMATEAR TAMAÑO
        |--------------------------------------------------------------------------
        */
        function formatFileSize(bytes) {
            if (bytes === 0) {
                return '0 Bytes';
            }
            const units = [
                'Bytes',
                'KB',
                'MB',
                'GB'
            ];
            const index = Math.floor(
                Math.log(bytes) / Math.log(1024)
            );
            return (
                parseFloat(
                    (bytes / Math.pow(1024, index)).toFixed(2)
                )
                + ' '
                + units[index]
            );
        }
        /*
        |--------------------------------------------------------------------------
        | GENERAR NOMBRE DEL DOCUMENTO
        |--------------------------------------------------------------------------
        */
        function generateDocumentName(filename) {
            const nameWithoutExtension =
                filename.replace(
                    /\.[^/.]+$/,
                    ''
                );
            return nameWithoutExtension
                .replace(/[_-]+/g, ' ')
                .trim();
        }
        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR CONTADOR
        |--------------------------------------------------------------------------
        */
        function updateDocumentCount() {
            const count = selectedFiles.length;
            if (!selectedCount || !selectedCountNumber) {
                return;
            }
            if (count === 0) {
                selectedCount.classList.add('hidden');
                selectedCountNumber.textContent = '0';
                if (submitUploadButton) {
                    submitUploadButton.textContent =
                        '📤 Subir archivos';
                }
                return;
            }
            selectedCount.classList.remove('hidden');
            selectedCountNumber.textContent = count;
            if (submitUploadButton) {
                submitUploadButton.textContent =
                    count === 1
                        ? '📤 Subir 1 archivo'
                        : `📤 Subir ${count} archivos`;
            }
        }
        /*
        |--------------------------------------------------------------------------
        | RENDERIZAR LISTA
        |--------------------------------------------------------------------------
        */
        function renderDocumentFileList() {
            if (!documentFileList) {
                return;
            }
            documentFileList.innerHTML = '';
            selectedFiles.forEach((item, index) => {
                const file = item.file;
                const extension =
                    file.name
                        .split('.')
                        .pop()
                        .toLowerCase();
                const icon =
                    getDocumentIcon(extension);
                const container =
                    document.createElement('div');
                container.className = `
                    rounded-xl
                    border
                    border-slate-200
                    dark:border-slate-800
                    bg-white
                    dark:bg-slate-900
                    p-4
                `;
                container.innerHTML = `
                    <div class="flex items-start gap-3">
                        {{-- ICONO --}}
                        <div
                            class="
                                w-12
                                h-12
                                rounded-lg
                                bg-slate-100
                                dark:bg-slate-800
                                flex
                                items-center
                                justify-center
                                flex-shrink-0
                                overflow-hidden
                            "
                        >
                            <img
                                src="${icon}"
                                alt="${extension}"
                                class="
                                    w-full
                                    h-full
                                    object-contain
                                    p-1
                                "
                            >
                        </div>
                        {{-- INFORMACIÓN --}}
                        <div class="flex-1 min-w-0">
                            <p
                                class="
                                    text-sm
                                    font-semibold
                                    text-slate-700
                                    dark:text-slate-200
                                    truncate
                                "
                            >
                                ${file.name}
                            </p>
                            <p
                                class="
                                    mt-0.5
                                    text-xs
                                    text-slate-500
                                    dark:text-slate-400
                                "
                            >
                                ${extension.toUpperCase()}
                                ·
                                ${formatFileSize(file.size)}
                            </p>
                        </div>
                        {{-- ELIMINAR --}}
                        <button
                            type="button"
                            class="
                                w-8
                                h-8
                                rounded-lg
                                flex
                                items-center
                                justify-center
                                text-slate-400
                                hover:text-red-500
                                hover:bg-red-50
                                dark:hover:bg-red-950/30
                                transition
                                flex-shrink-0
                            "
                            onclick="removeDocumentFile(${index})"
                        >
                            <img
                                src="{{ asset('images/documentacion/salir.png') }}"
                                alt="Cerrar"
                                class="w-5 h-5 object-contain"
                            >
                        </button>
                    </div>
                    {{-- NOMBRE --}}
                    <div class="mt-4">
                        <label
                            class="
                                block
                                text-xs
                                font-semibold
                                text-slate-600
                                dark:text-slate-300
                                mb-1.5
                            "
                        >
                            Nombre del documento
                        </label>
                        <input
                            type="text"
                            value="${escapeHtml(item.name)}"
                            class="
                                document-name-input
                                w-full
                                rounded-lg
                                border
                                border-slate-300
                                dark:border-slate-700
                                bg-white
                                dark:bg-slate-950
                                text-sm
                                text-slate-700
                                dark:text-slate-200
                                px-3
                                py-2
                                outline-none
                                focus:border-blue-500
                                focus:ring-1
                                focus:ring-blue-500
                            "
                            data-index="${index}"
                        >
                    </div>
                    ${item.error ? `
                        <div class="
                            mt-3
                            rounded-lg
                            border
                            border-red-200
                            dark:border-red-900
                            bg-red-50
                            dark:bg-red-950/30
                            px-3
                            py-2
                            text-xs
                            text-red-600
                            dark:text-red-400
                        ">
                            <span class="font-semibold">
                                ⚠️ Error:
                            </span>

                            ${escapeHtml(item.error)}
                        </div>
                    ` : ''}
                    {{-- DESCRIPCIÓN --}}
                    <div class="mt-3">
                        <label
                            class="
                                block
                                text-xs
                                font-semibold
                                text-slate-600
                                dark:text-slate-300
                                mb-1.5
                            "
                        >
                            Descripción
                            <span class="font-normal text-slate-400">
                                (opcional)
                            </span>
                        </label>
                        <textarea
                            rows="2"
                            class="
                                document-description-input
                                w-full
                                rounded-lg
                                border
                                border-slate-300
                                dark:border-slate-700
                                bg-white
                                dark:bg-slate-950
                                text-sm
                                text-slate-700
                                dark:text-slate-200
                                px-3
                                py-2
                                outline-none
                                focus:border-blue-500
                                focus:ring-1
                                focus:ring-blue-500
                                resize-none
                            "
                            data-index="${index}"
                            placeholder="Descripción del documento..."
                        >${escapeHtml(item.description)}</textarea>
                    </div>
                `;
                documentFileList.appendChild(container);
            });
            updateDocumentCount();
        }
        /*
        |--------------------------------------------------------------------------
        | DRAG & DROP
        |--------------------------------------------------------------------------
        */
        const documentDropZone = document.getElementById('document-drop-zone');
        const documentDragOverlay = document.getElementById('document-drag-overlay');
        /*
        |--------------------------------------------------------------------------
        | AGREGAR ARCHIVOS
        |--------------------------------------------------------------------------
        */
        function addDocumentFiles(files) {
            if (!files || !files.length) {
                return;
            }
            Array.from(files).forEach(file => {
                const exists =
                    selectedFiles.some(
                        item =>
                            item.file.name === file.name &&
                            item.file.size === file.size &&
                            item.file.lastModified === file.lastModified
                    );
                if (!exists) {
                    selectedFiles.push({
                        file: file,
                        name:
                            generateDocumentName(
                                file.name
                            ),

                        description: ''
                    });
                }
            });
            renderDocumentFileList();
        }
        /*
        |--------------------------------------------------------------------------
        | MOSTRAR OVERLAY
        |--------------------------------------------------------------------------
        */
        function showDocumentDragOverlay() {
            if (!documentDragOverlay) {
                return;
            }
            documentDragOverlay.classList.remove(
                'hidden'
            );
            documentDragOverlay.classList.add(
                'flex'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | OCULTAR OVERLAY
        |--------------------------------------------------------------------------
        */

        function hideDocumentDragOverlay() {
            if (!documentDragOverlay) {
                return;
            }
            documentDragOverlay.classList.add(
                'hidden'
            );
            documentDragOverlay.classList.remove(
                'flex'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | DETECTAR ARRASTRE DE ARCHIVOS
        |--------------------------------------------------------------------------
        */
        let isDraggingFiles = false;

        document.addEventListener(
            'dragenter',
            function (event) {
                if (
                    !event.dataTransfer ||
                    !event.dataTransfer.types.includes('Files')
                ) {
                    return;
                }
                event.preventDefault();
                isDraggingFiles = true;
                showDocumentDragOverlay();
            }
        );
        /*
        |--------------------------------------------------------------------------
        | DRAGOVER
        |--------------------------------------------------------------------------
        */
        document.addEventListener(
            'dragover',
            function (event) {
                if (
                    !event.dataTransfer ||
                    !event.dataTransfer.types.includes('Files')
                ) {
                    return;
                }
                event.preventDefault();
            }
        );
        /*
        |--------------------------------------------------------------------------
        | SOLTAR ARCHIVOS
        |--------------------------------------------------------------------------
        */
        document.addEventListener(
            'drop',
            function (event) {
                if (
                    !event.dataTransfer ||
                    !event.dataTransfer.files.length
                ) {
                    return;
                }
                event.preventDefault();
                const files =
                    event.dataTransfer.files;

                hideDocumentDragOverlay();

                isDraggingFiles = false;
                /*
                |--------------------------------------------------------------------------
                | Abrir modal
                |--------------------------------------------------------------------------
                */
                openDocumentUploadModal();
                /*
                |--------------------------------------------------------------------------
                | Agregar archivos
                |--------------------------------------------------------------------------
                */
                addDocumentFiles(files);
            }
        );
        /*
        |--------------------------------------------------------------------------
        | SALIR DE LA VENTANA
        |--------------------------------------------------------------------------
        */
        document.addEventListener(
            'dragleave',
            function (event) {
                if (
                    event.clientX <= 0 ||
                    event.clientY <= 0 ||
                    event.clientX >= window.innerWidth ||
                    event.clientY >= window.innerHeight
                ) {
                    isDraggingFiles = false;
                    hideDocumentDragOverlay();
                }
            }
        );
        /*
        |--------------------------------------------------------------------------
        | ESCAPAR HTML
        |--------------------------------------------------------------------------
        */
        function escapeHtml(value) {
            if (!value) {
                return '';
            }
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }
        /*
        |--------------------------------------------------------------------------
        | SELECCIONAR ARCHIVOS
        |--------------------------------------------------------------------------
        */
        if (documentFileInput) {
            documentFileInput.addEventListener(
                'change',
                function () {
                    addDocumentFiles(
                        this.files
                    );
                    /*
                    |--------------------------------------------------------------------------
                    | Permitir seleccionar nuevamente
                    |--------------------------------------------------------------------------
                    */
                    this.value = '';
                }
            );
        }
        /*
        |--------------------------------------------------------------------------
        | CAMBIAR NOMBRE
        |--------------------------------------------------------------------------
        */
        if (documentFileList) {
            documentFileList.addEventListener(
                'input',
                function (event) {
                    if (
                        event.target.classList.contains(
                            'document-name-input'
                        )
                    ) {
                        const index =
                            Number(
                                event.target.dataset.index
                            );
                        if (
                            selectedFiles[index]
                        ) {
                            selectedFiles[index].name =
                                event.target.value;
                        }
                    }
                    /*
                    |--------------------------------------------------------------------------
                    | CAMBIAR DESCRIPCIÓN
                    |--------------------------------------------------------------------------
                    */
                    if (
                        event.target.classList.contains(
                            'document-description-input'
                        )
                    ) {
                        const index =
                            Number(
                                event.target.dataset.index
                            );
                        if (
                            selectedFiles[index]
                        ) {

                            selectedFiles[index].description =
                                event.target.value;

                        }
                    }
                }
            );
        }
        /*
        |--------------------------------------------------------------------------
        | ELIMINAR ARCHIVO
        |--------------------------------------------------------------------------
        */
        window.removeDocumentFile = function (index) {
            selectedFiles.splice(index, 1);
            renderDocumentFileList();
        };
        /*
        |--------------------------------------------------------------------------
        | REINICIAR MODAL
        |--------------------------------------------------------------------------
        */
        function resetDocumentUploadModal() {
            selectedFiles = [];
            if (documentFileInput) {
                documentFileInput.value = '';
            }
            if (documentFileList) {
                documentFileList.innerHTML = '';
            }
            updateDocumentCount();
        }
        /*
        |--------------------------------------------------------------------------
        | LIMPIAR AL CERRAR
        |--------------------------------------------------------------------------
        */
        if (cancelUploadButton) {
            cancelUploadButton.addEventListener(
                'click',
                resetDocumentUploadModal
            );
        }
        if (closeUploadButton) {
            closeUploadButton.addEventListener(
                'click',
                resetDocumentUploadModal
            );
        }
        /*
        |--------------------------------------------------------------------------
        | SUBIR DOCUMENTOS
        |--------------------------------------------------------------------------
        */
        if (submitUploadButton) {
            submitUploadButton.addEventListener(
                'click',
                async function () {
                    /*
                    |--------------------------------------------------------------------------
                    | VALIDAR QUE EXISTAN ARCHIVOS
                    |--------------------------------------------------------------------------
                    */
                    if (selectedFiles.length === 0) {
                        alert(
                            'Debes seleccionar al menos un archivo.'
                        );
                        return;
                    }
                    /*
                    |--------------------------------------------------------------------------
                    | PREPARAR SUBIDA
                    |--------------------------------------------------------------------------
                    */
                    submitUploadButton.disabled = true;
                    submitUploadButton.classList.add(
                        'opacity-70',
                        'cursor-not-allowed'
                    );

                    const totalFiles = selectedFiles.length;
                    let uploadedFiles = 0;
                    let failedFiles = [];

                    /*
                    |--------------------------------------------------------------------------
                    | CALCULAR CANTIDAD DE LOTES
                    |--------------------------------------------------------------------------
                    */

                    const totalBatches = Math.ceil(
                        totalFiles / BATCH_SIZE
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | PROCESAR LOTES
                    |--------------------------------------------------------------------------
                    */

                    for (
                        let batchIndex = 0;
                        batchIndex < totalBatches;
                        batchIndex++
                    ) {
                        const startIndex = batchIndex * BATCH_SIZE;
                        const batch = selectedFiles.slice(startIndex, startIndex + BATCH_SIZE);
                        /*
                        |--------------------------------------------------------------------------
                        | CREAR FORMDATA
                        |--------------------------------------------------------------------------
                        */

                        const formData = new FormData();

                        formData.append(
                            '_token',
                            documentCsrfToken
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | AGREGAR ARCHIVOS DEL LOTE
                        |--------------------------------------------------------------------------
                        */

                        batch.forEach(
                            (item, index) => {
                                formData.append(
                                    `files[${index}]`,
                                    item.file
                                );
                                formData.append(
                                    `names[${index}]`,
                                    item.name ?? ''
                                );
                                formData.append(
                                    `descriptions[${index}]`,
                                    item.description ?? ''
                                );
                            }
                        );
                        /*
                        |--------------------------------------------------------------------------
                        | ACTUALIZAR BOTÓN
                        |--------------------------------------------------------------------------
                        */
                        submitUploadButton.textContent =
                            `⏳ ${uploadedFiles} de ${totalFiles} archivos subidos`;

                        try {
                            /*
                            |--------------------------------------------------------------------------
                            | ENVIAR LOTE
                            |--------------------------------------------------------------------------
                            */
                            let response = await fetch(
                                documentStoreUrl,
                                {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-Requested-With':
                                            'XMLHttpRequest',

                                        'Accept':
                                            'application/json'
                                    }
                                }
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | LEER RESPUESTA
                            |--------------------------------------------------------------------------
                            */

                            let data = {};
                            try {
                                data = await response.json();
                            } catch (error) {
                                data = {};
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | ERROR HTTP DEL LOTE
                            |--------------------------------------------------------------------------
                            |
                            | Si por alguna razón falla todo el lote,
                            | marcamos todos sus archivos como fallidos,
                            | pero CONTINUAMOS con el siguiente lote.
                            |
                            */

                            if (!response.ok) {
                                if (response.status === 409 && data.requires_confirmation) {
                                    const fileName = data.file_name || 'este archivo';

                                    const replace = confirm(
                                        `Ya existe un archivo llamado "${fileName}" en esta carpeta.\n\n` +
                                        `¿Deseas reemplazar la versión actual?`
                                    );

                                    if (!replace) {
                                        batch.forEach((item) => {
                                            item.error = 'El archivo ya existe y no fue reemplazado.';
                                            failedFiles.push(item);
                                        });

                                        continue;
                                    }

                                    formData.append(
                                        'replace_document_id',
                                        data.document_id
                                    );

                                    const replaceResponse = await fetch(
                                        documentStoreUrl,
                                        {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest',
                                                'Accept': 'application/json'
                                            }
                                        }
                                    );

                                    response = replaceResponse;

                                    try {
                                        data = await response.json();
                                    } catch (error) {
                                        data = {};
                                    }
                                }

                                if (!response.ok) {
                                    batch.forEach((item) => {
                                        item.error =
                                            data.message ||
                                            'No fue posible procesar este archivo.';
                                        failedFiles.push(item);
                                    });

                                    continue;
                                }
                            }
                            /*
                            |--------------------------------------------------------------------------
                            | ARCHIVOS SUBIDOS CORRECTAMENTE
                            |--------------------------------------------------------------------------
                            */

                            uploadedFiles +=
                                Number(data.uploaded || 0);

                            /*
                            |--------------------------------------------------------------------------
                            | ARCHIVOS FALLIDOS
                            |--------------------------------------------------------------------------
                            */

                            if (
                                Array.isArray(data.failed) &&
                                data.failed.length > 0
                            ) {
                                data.failed.forEach(
                                    (failure) => {
                                        const item =
                                            batch[failure.index];
                                        if (!item) {
                                            return;
                                        }
                                        item.error =
                                            Array.isArray(
                                                failure.errors
                                            )
                                                ? failure.errors.join(' ')
                                                : (
                                                    failure.errors ||
                                                    'No fue posible subir este archivo.'
                                                );
                                        failedFiles.push(item);
                                    }
                                );
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | ACTUALIZAR PROGRESO
                            |--------------------------------------------------------------------------
                            */
                            submitUploadButton.textContent =
                                `⏳ ${uploadedFiles} de ${totalFiles} archivos subidos`;
                        } catch (error) {
                            console.error(
                                'Error al subir lote:',
                                error
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | SI FALLA EL FETCH
                            |--------------------------------------------------------------------------
                            |
                            | No detenemos todo el proceso.
                            | Marcamos este lote como fallido
                            | y seguimos con el siguiente.
                            |
                            */

                            batch.forEach(
                                (item) => {
                                    item.error =
                                        error.message ||
                                        'No fue posible subir este archivo.';
                                    failedFiles.push(item);
                                }
                            );
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | FINALIZÓ TODA LA SUBIDA
                    |--------------------------------------------------------------------------
                    */

                    console.log('Archivos subidos:', uploadedFiles);
                    console.log('Archivos fallidos:', failedFiles);

                    /*
                    |--------------------------------------------------------------------------
                    | SI NO HUBO ERRORES
                    |--------------------------------------------------------------------------
                    */

                    if (failedFiles.length === 0) {
                        alert(
                            `¡Listo! Se subieron ${uploadedFiles} documento(s) correctamente.`
                        );
                        window.location.reload();
                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | CONSERVAR SOLAMENTE LOS ARCHIVOS FALLIDOS
                    |--------------------------------------------------------------------------
                    |
                    | Los archivos exitosos desaparecen de la lista.
                    | Los fallidos permanecen para poder corregirlos
                    | y volver a intentar.
                    |
                    */

                    selectedFiles = failedFiles;

                    /*
                    |--------------------------------------------------------------------------
                    | VOLVER A MOSTRAR LA LISTA
                    |--------------------------------------------------------------------------
                    */

                    renderDocumentFileList();

                    /*
                    |--------------------------------------------------------------------------
                    | RESTAURAR BOTÓN
                    |--------------------------------------------------------------------------
                    */

                    submitUploadButton.disabled = false;

                    submitUploadButton.classList.remove(
                        'opacity-70',
                        'cursor-not-allowed'
                    );

                    submitUploadButton.textContent =
                        `🔄 Reintentar ${failedFiles.length} documento(s)`;

                }
            );

        }
        /*
        |--------------------------------------------------------------------------
        | MODAL EDITAR DOCUMENTO
        |--------------------------------------------------------------------------
        */
        const documentEditModal = document.getElementById('document-edit-modal');
        const documentEditForm = document.getElementById('document-edit-form');
        const editDocumentName = document.getElementById('edit-document-name');
        const editDocumentDescription = document.getElementById('edit-document-description');
        const editDocumentFileName = document.getElementById('edit-document-file-name');
        const closeDocumentEditButton = document.getElementById('close-document-edit-modal');
        const cancelDocumentEditButton = document.getElementById('cancel-document-edit-modal');
        /*
        |--------------------------------------------------------------------------
        | ABRIR MODAL
        |--------------------------------------------------------------------------
        */
        function openDocumentEditModal(button) {
            if (!documentEditModal) {
                return;
            }
            /*
            |--------------------------------------------------------------------------
            | OBTENER DATOS DEL DOCUMENTO
            |--------------------------------------------------------------------------
            */
            const documentId = button.dataset.documentId;
            const documentName = button.dataset.documentName || '';
            const documentDescription = button.dataset.documentDescription || '';
            const documentFileName = button.dataset.documentFileName || '';
            const documentExtension = button.dataset.documentExtension || '';
            /*
            |--------------------------------------------------------------------------
            | RELLENAR CAMPOS
            |--------------------------------------------------------------------------
            */
            if (editDocumentFileIcon) {
                const iconMap = {
                    pdf: '/images/documentacion/pdf.png',
                    doc: '/images/documentacion/word.png',
                    docx: '/images/documentacion/word.png',
                    xls: '/images/documentacion/excel.png',
                    xlsx: '/images/documentacion/excel.png',
                    sql: '/images/documentacion/sql.png',
                    txt: '/images/documentacion/txt.png',
                    zip: '/images/documentacion/rar.png',
                    rar: '/images/documentacion/rar.png',
                    jpg: '/images/documentacion/imagen.png',
                    jpeg: '/images/documentacion/imagen.png',
                    png: '/images/documentacion/imagen.png',
                    xml: '/images/documentacion/xml.png',
                };
                editDocumentFileIcon.src =
                    iconMap[documentExtension]
                    || '/images/documentacion/default.png';
            }
            if (editDocumentName) {
                editDocumentName.value =
                    documentName;
            }
            if (editDocumentDescription) {
                editDocumentDescription.value =
                    documentDescription;
            }
            if (editDocumentFileName) {
                editDocumentFileName.textContent =
                    documentFileName;
            }
            /*
            |--------------------------------------------------------------------------
            | CONFIGURAR ACTION DEL FORMULARIO
            |--------------------------------------------------------------------------
            */
            if (documentEditForm) {
                documentEditForm.action =
                    `/documentacion/documentos/${documentId}`;
            }
            /*
            |--------------------------------------------------------------------------
            | ABRIR
            |--------------------------------------------------------------------------
            */
            documentEditModal.classList.remove(
                'hidden'
            );
            documentEditModal.classList.add(
                'flex'
            );
            /*
            |--------------------------------------------------------------------------
            | ENFOCAR NOMBRE
            |--------------------------------------------------------------------------
            */
            setTimeout(() => {
                if (editDocumentName) {
                    editDocumentName.focus();
                }
            }, 100);
        }
        /*
        |--------------------------------------------------------------------------
        | CERRAR MODAL
        |--------------------------------------------------------------------------
        */
        function closeDocumentEditModal() {
            if (!documentEditModal) {
                return;
            }
            documentEditModal.classList.add(
                'hidden'
            );
            documentEditModal.classList.remove(
                'flex'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | BOTÓN X
        |--------------------------------------------------------------------------
        */
        if (closeDocumentEditButton) {
            closeDocumentEditButton.addEventListener(
                'click',
                closeDocumentEditModal
            );
        }
        /*
        |--------------------------------------------------------------------------
        | BOTÓN CANCELAR
        |--------------------------------------------------------------------------
        */
        if (cancelDocumentEditButton) {
            cancelDocumentEditButton.addEventListener(
                'click',
                closeDocumentEditModal
            );
        }
        /*
        |--------------------------------------------------------------------------
        | CERRAR AL HACER CLICK FUERA
        |--------------------------------------------------------------------------
        */
        if (documentEditModal) {
            documentEditModal.addEventListener(
                'click',
                function (event) {
                    if (
                        event.target ===
                        documentEditModal
                    ) {
                        closeDocumentEditModal();
                    }
                }
            );
        }
        /*
        |--------------------------------------------------------------------------
        | MODAL ELIMINAR DOCUMENTO
        |--------------------------------------------------------------------------
        */

        const documentDeleteModal = document.getElementById('document-delete-modal');
        const documentDeleteForm = document.getElementById('document-delete-form');
        const deleteDocumentName = document.getElementById('delete-document-name');
        const deleteDocumentFileName = document.getElementById('delete-document-file-name');
        const closeDocumentDeleteButton = document.getElementById('close-document-delete-modal');
        const cancelDocumentDeleteButton = document.getElementById('cancel-document-delete-modal');
        /*
        |--------------------------------------------------------------------------
        | ABRIR MODAL
        |--------------------------------------------------------------------------
        */
        window.openDocumentDeleteModal = function (button) {
            if (!documentDeleteModal) {
                return;
            }
            /*
            |--------------------------------------------------------------------------
            | OBTENER DATOS
            |--------------------------------------------------------------------------
            */
            const documentId = button.dataset.documentId;

            const documentName = button.dataset.documentName || '';

            const documentFileName = button.dataset.documentFileName || '';

            const documentExtension = button.dataset.documentExtension || '';
            /*
            |--------------------------------------------------------------------------
            | NOMBRE DEL DOCUMENTO
            |--------------------------------------------------------------------------
            */
            if (deleteDocumentName) {
                deleteDocumentName.textContent =
                    documentName;
            }
            /*
            |--------------------------------------------------------------------------
            | NOMBRE DEL ARCHIVO
            |--------------------------------------------------------------------------
            */
            if (deleteDocumentFileName) {
                deleteDocumentFileName.textContent =
                    documentFileName;
            }
            /*
            |--------------------------------------------------------------------------
            | ICONO
            |--------------------------------------------------------------------------
            */
            if (deleteDocumentFileIcon) {
                const iconMap = {
                    pdf: '/images/documentacion/pdf.png',
                    doc: '/images/documentacion/word.png',
                    docx: '/images/documentacion/word.png',
                    xls: '/images/documentacion/excel.png',
                    xlsx: '/images/documentacion/excel.png',
                    sql: '/images/documentacion/sql.png',
                    txt: '/images/documentacion/txt.png',
                    zip: '/images/documentacion/rar.png',
                    rar: '/images/documentacion/rar.png',
                    jpg: '/images/documentacion/imagen.png',
                    jpeg: '/images/documentacion/imagen.png',
                    png: '/images/documentacion/imagen.png',
                    xml: '/images/documentacion/xml.png',
                };

                deleteDocumentFileIcon.src = iconMap[documentExtension] || '/images/documentacion/default.png';
            }
            /*
            |--------------------------------------------------------------------------
            | CARGAR ICONO SEGÚN EXTENSIÓN
            |--------------------------------------------------------------------------
            */
            if (deleteDocumentFileIcon) {
                const iconMap = {
                    pdf: '/images/documentacion/pdf.png',
                    doc: '/images/documentacion/word.png',
                    docx: '/images/documentacion/word.png',
                    xls: '/images/documentacion/excel.png',
                    xlsx: '/images/documentacion/excel.png',
                    sql: '/images/documentacion/sql.png',
                    txt: '/images/documentacion/txt.png',
                    zip: '/images/documentacion/rar.png',
                    rar: '/images/documentacion/rar.png',
                    jpg: '/images/documentacion/imagen.png',
                    jpeg: '/images/documentacion/imagen.png',
                    png: '/images/documentacion/imagen.png',
                    xml: '/images/documentacion/xml.png',
            };
            deleteDocumentFileIcon.src = iconMap[documentExtension] || '';
            }
            /*
            |--------------------------------------------------------------------------
            | ACTION DEL FORMULARIO
            |--------------------------------------------------------------------------
            */
            if (documentDeleteForm) {
                documentDeleteForm.action =
                    `/documentacion/documentos/${documentId}`;
            }
            /*
            |--------------------------------------------------------------------------
            | ABRIR MODAL
            |--------------------------------------------------------------------------
            */
            documentDeleteModal.classList.remove(
                'hidden'
            );
            documentDeleteModal.classList.add(
                'flex'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | CERRAR MODAL
        |--------------------------------------------------------------------------
        */
        function closeDocumentDeleteModal() {
            if (!documentDeleteModal) {
                return;
            }
            documentDeleteModal.classList.add(
                'hidden'
            );
            documentDeleteModal.classList.remove(
                'flex'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | BOTÓN X
        |--------------------------------------------------------------------------
        */
        if (closeDocumentDeleteButton) {
            closeDocumentDeleteButton.addEventListener(
                'click',
                closeDocumentDeleteModal
            );
        }
        /*
        |--------------------------------------------------------------------------
        | BOTÓN CANCELAR
        |--------------------------------------------------------------------------
        */
        if (cancelDocumentDeleteButton) {
            cancelDocumentDeleteButton.addEventListener(
                'click',
                closeDocumentDeleteModal
            );
        }
        /*
        |--------------------------------------------------------------------------
        | CERRAR AL HACER CLICK FUERA
        |--------------------------------------------------------------------------
        */
        if (documentDeleteModal) {
            documentDeleteModal.addEventListener(
                'click',
                function (event) {
                    if (
                        event.target ===
                        documentDeleteModal
                    ) {
                        closeDocumentDeleteModal();
                    }
                }
            );
        }
    </script>
</x-app-layout>