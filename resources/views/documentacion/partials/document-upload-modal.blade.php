{{-- Modal: Subir documentos --}}

<div
    id="document-upload-modal"
    class="
        hidden
        fixed
        inset-0
        z-50
        bg-black/60
        items-center
        justify-center
        p-4
    "
>

    <div
        class="
            relative
            w-full
            max-w-2xl
            max-h-[90vh]
            flex
            flex-col
            rounded-2xl
            bg-white
            dark:bg-[#020817]
            border
            border-slate-200
            dark:border-slate-800
            shadow-2xl
            overflow-hidden
        "
    >

        {{-- HEADER --}}
        <div
            class="
                flex
                items-center
                justify-between
                px-6
                py-5
                border-b
                border-slate-200
                dark:border-slate-800
                flex-shrink-0
            "
        >

            <div>

                <h2
                    class="
                        text-xl
                        font-bold
                        text-slate-700
                        dark:text-slate-200
                    "
                >
                    Subir documentos
                </h2>

                <p
                    class="
                        mt-1
                        text-sm
                        text-slate-500
                        dark:text-slate-400
                    "
                >
                    Agrega archivos a
                    <span
                        class="font-semibold"
                    >
                        {{ $category->name }}
                    </span>
                </p>

            </div>


            {{-- CERRAR --}}
            <button
                type="button"
                id="close-document-upload-modal"
                class="
                    w-9
                    h-9
                    rounded-xl
                    flex
                    items-center
                    justify-center
                    text-slate-500
                    dark:text-slate-400
                    hover:bg-slate-100
                    dark:hover:bg-slate-800
                    transition
                "
            >
                <img
                    src="{{ asset('images/documentacion/salir.png') }}"
                    alt="Cerrar"
                    class="w-5 h-5 object-contain"
                >
            </button>

        </div>


        {{-- CONTENIDO --}}
        <div
            class="
                overflow-y-auto
                px-6
                py-6
                space-y-5
            "
        >

            {{-- ZONA DE ARCHIVOS --}}
            <div>

                <label
                    for="document-file"
                    id="document-drop-zone"
                    class="
                        block
                        cursor-pointer
                        rounded-xl
                        border-2
                        border-dashed
                        border-slate-300
                        dark:border-slate-700
                        hover:border-blue-500
                        dark:hover:border-blue-500
                        bg-slate-50
                        dark:bg-slate-900/50
                        px-5
                        py-7
                        text-center
                        transition
                    "
                >

                    <div class="text-3xl mb-2">
                        📎
                    </div>


                    <p
                        class="
                            text-sm
                            font-semibold
                            text-slate-700
                            dark:text-slate-200
                        "
                    >
                        Haz clic para seleccionar archivos
                    </p>


                    <p
                        class="
                            mt-1
                            text-xs
                            text-slate-500
                            dark:text-slate-400
                        "
                    >
                        También podrás arrastrarlos aquí
                    </p>


                    <p
                        class="
                            mt-2
                            text-xs
                            text-slate-500
                            dark:text-slate-400
                        "
                    >
                        PDF, Word, Excel, SQL, TXT, imágenes, ZIP y RAR
                    </p>


                    <input
                        type="file"
                        id="document-file"
                        class="hidden"
                        multiple
                    >

                </label>

            </div>


            {{-- CONTADOR --}}
            <div
                id="document-selected-count"
                class="
                    hidden
                    flex
                    items-center
                    justify-between
                    px-1
                "
            >

                <span
                    class="
                        text-sm
                        font-semibold
                        text-slate-700
                        dark:text-slate-200
                    "
                >
                    Archivos seleccionados
                </span>


                <span
                    id="document-selected-count-number"
                    class="
                        px-2.5
                        py-1
                        rounded-lg
                        bg-slate-100
                        dark:bg-slate-800
                        text-xs
                        font-bold
                        text-slate-700
                        dark:text-slate-200
                    "
                >
                    0
                </span>

            </div>


            {{-- LISTA DE ARCHIVOS --}}
            <div
                id="document-file-list"
                class="space-y-3"
            ></div>

        </div>


        {{-- FOOTER --}}
        <div
            class="
                flex
                items-center
                justify-end
                gap-3
                px-6
                py-4
                border-t
                border-slate-200
                dark:border-slate-800
                bg-slate-50
                dark:bg-slate-900/40
                flex-shrink-0
            "
        >

            {{-- CANCELAR --}}
            <button
                type="button"
                id="cancel-document-upload-modal"
                class="
                    px-5
                    py-2.5
                    rounded-xl
                    bg-slate-200
                    hover:bg-slate-300
                    dark:bg-slate-800
                    dark:hover:bg-slate-700
                    text-slate-700
                    dark:text-slate-200
                    font-semibold
                    transition
                "
            >
                Cancelar
            </button>


            {{-- SUBIR --}}
            <button
                type="button"
                id="submit-document-upload"
                class="
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
                📤 Subir archivos
            </button>

        </div>

    </div>

</div>