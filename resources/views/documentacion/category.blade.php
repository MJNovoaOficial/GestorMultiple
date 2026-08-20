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
                        ← Volver a documentación
                    </a>


                    <div class="flex items-center gap-4">

                        {{-- IMAGEN DE CATEGORÍA --}}
                        <div
                            class="
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
                                    class="w-full h-full object-contain p-3"
                                >

                            @endif

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
                                {{ $category->name }}
                            </h1>

                            @if($category->description)

                                <p
                                    class="
                                        mt-1
                                        text-sm
                                        text-slate-500
                                        dark:text-slate-400
                                    "
                                >
                                    {{ $category->description }}
                                </p>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- SUBIR ARCHIVO --}}
                <button
                    type="button"
                    id="open-document-upload-modal"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        gap-2
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
                    <span class="text-lg">+</span>
                    Subir archivo
                </button>

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

            </div>


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
                                hover:bg-slate-50
                                dark:hover:bg-slate-900/50
                                transition
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
                                "
                            >
                                📄
                            </div>


                            {{-- INFORMACIÓN --}}
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


                                <div
                                    class="
                                        flex
                                        flex-wrap
                                        items-center
                                        gap-x-3
                                        gap-y-1
                                        mt-1
                                        text-xs
                                        text-slate-500
                                        dark:text-slate-400
                                    "
                                >

                                    <span>
                                        {{ strtoupper($document->file_type) }}
                                    </span>

                                    <span>•</span>

                                    <span>
                                        {{ number_format($document->file_size / 1024, 2) }} KB
                                    </span>

                                    <span>•</span>

                                    <span>
                                        {{ $document->creator->name ?? 'Usuario desconocido' }}
                                    </span>

                                </div>


                                @if($document->description)

                                    <p
                                        class="
                                            mt-1
                                            text-xs
                                            text-slate-500
                                            dark:text-slate-400
                                            truncate
                                        "
                                    >
                                        {{ $document->description }}
                                    </p>

                                @endif

                            </div>


                            {{-- OPCIONES --}}
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
                            >
                                ⋮
                            </button>

                        </div>

                    @endforeach

                </div>

            @else

                {{-- SIN DOCUMENTOS --}}
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

                    <div class="text-5xl mb-5">
                        📄
                    </div>


                    <h2
                        class="
                            text-xl
                            font-bold
                            text-slate-700
                            dark:text-slate-200
                        "
                    >
                        No hay documentos
                    </h2>


                    <p
                        class="
                            mt-2
                            text-sm
                            text-slate-500
                            dark:text-slate-400
                        "
                    >
                        Esta categoría todavía no contiene documentos.
                    </p>


                    <button
                        type="button"
                        id="open-document-upload-modal-empty"
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
                        <span class="text-lg">+</span>
                        Subir primer archivo
                    </button>

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

    @include('documentacion.partials.document-upload-modal')

    <script>
        const documentStoreUrl =
            @json(route('documentacion.documents.store', $category));
    </script>

    <script>
        /*
        |--------------------------------------------------------------------------
        | MODAL SUBIR DOCUMENTOS
        |--------------------------------------------------------------------------
        */
        const uploadModal = document.getElementById(
            'document-upload-modal'
        );

        const openUploadButton = document.getElementById(
            'open-document-upload-modal'
        );

        const openUploadEmptyButton = document.getElementById(
            'open-document-upload-modal-empty'
        );

        const closeUploadButton = document.getElementById(
            'close-document-upload-modal'
        );

        const cancelUploadButton = document.getElementById(
            'cancel-document-upload-modal'
        );

        const submitUploadButton = document.getElementById(
            'submit-document-upload'
        );

        /*
        |--------------------------------------------------------------------------
        | ARCHIVOS
        |--------------------------------------------------------------------------
        */

        const documentFileInput = document.getElementById(
            'document-file'
        );

        const documentFileList = document.getElementById(
            'document-file-list'
        );

        const selectedCount = document.getElementById(
            'document-selected-count'
        );

        const selectedCountNumber = document.getElementById(
            'document-selected-count-number'
        );

        /*
        |--------------------------------------------------------------------------
        | ARCHIVOS SELECCIONADOS
        |--------------------------------------------------------------------------
        */

        let selectedFiles = [];
      
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
                            ✕
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

        const documentDropZone = document.getElementById(
            'document-drop-zone'
        );

        const documentDragOverlay = document.getElementById(
            'document-drag-overlay'
        );

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
                    | CREAR FORMDATA
                    |--------------------------------------------------------------------------
                    */

                    const formData = new FormData();


                    /*
                    |--------------------------------------------------------------------------
                    | CSRF
                    |--------------------------------------------------------------------------
                    */

                    formData.append(
                        '_token',
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).getAttribute('content')
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | AGREGAR ARCHIVOS
                    |--------------------------------------------------------------------------
                    */

                    selectedFiles.forEach(
                        (item, index) => {

                            formData.append(
                                `files[${index}]`,
                                item.file
                            );

                            formData.append(
                                `names[${index}]`,
                                item.name
                            );

                            formData.append(
                                `descriptions[${index}]`,
                                item.description ?? ''
                            );

                        }
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | DESHABILITAR BOTÓN
                    |--------------------------------------------------------------------------
                    */

                    submitUploadButton.disabled = true;

                    submitUploadButton.classList.add(
                        'opacity-70',
                        'cursor-not-allowed'
                    );

                    submitUploadButton.textContent =
                        '⏳ Subiendo...';


                    try {

                        /*
                        |--------------------------------------------------------------------------
                        | ENVIAR AL SERVIDOR
                        |--------------------------------------------------------------------------
                        */

                        const response = await fetch(
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


                        /*
                        |--------------------------------------------------------------------------
                        | ERROR HTTP
                        |--------------------------------------------------------------------------
                        */

                        if (!response.ok) {

                            let errorMessage =
                                'No fue posible subir los documentos.';

                            try {

                                const data =
                                    await response.json();

                                if (data.message) {

                                    errorMessage =
                                        data.message;

                                }

                            } catch (error) {
                                // La respuesta no era JSON.
                            }


                            throw new Error(
                                errorMessage
                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | ÉXITO
                        |--------------------------------------------------------------------------
                        */

                        window.location.reload();


                    } catch (error) {

                        console.error(
                            'Error al subir documentos:',
                            error
                        );


                        alert(
                            error.message ||
                            'No fue posible subir los documentos.'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | RESTAURAR BOTÓN
                        |--------------------------------------------------------------------------
                        */

                        submitUploadButton.disabled =
                            false;

                        submitUploadButton.classList.remove(
                            'opacity-70',
                            'cursor-not-allowed'
                        );


                        updateDocumentCount();

                    }

                }
            );

        }
    </script>
</x-app-layout>