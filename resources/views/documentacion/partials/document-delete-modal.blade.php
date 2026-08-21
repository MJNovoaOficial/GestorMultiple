{{-- Modal: Eliminar documento --}}

<div
    id="document-delete-modal"
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
            max-w-md
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
                    Enviar a la papelera
                </h2>

                <p
                    class="
                        mt-1
                        text-sm
                        text-slate-500
                        dark:text-slate-400
                    "
                >
                    El documento podrá restaurarse posteriormente.
                </p>

            </div>


            {{-- CERRAR --}}
            <button
                type="button"
                id="close-document-delete-modal"
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
                ✕
            </button>

        </div>


        {{-- CONTENIDO --}}
        <div class="px-6 py-6">

            <div
                class="
                    flex
                    items-center
                    gap-4
                    rounded-xl
                    bg-slate-50
                    dark:bg-slate-900/60
                    border
                    border-slate-200
                    dark:border-slate-800
                    p-4
                "
            >

                {{-- ICONO --}}
                <div
                    class="
                        w-12
                        h-12
                        rounded-xl
                        bg-white
                        dark:bg-slate-800
                        border
                        border-slate-200
                        dark:border-slate-700
                        flex
                        items-center
                        justify-center
                        flex-shrink-0
                        overflow-hidden
                    "
                >

                    <img
                        id="delete-document-file-icon"
                        src=""
                        alt="Icono del archivo"
                        class="
                            w-full
                            h-full
                            object-contain
                            p-2
                        "
                    >

                </div>


                {{-- INFORMACIÓN --}}
                <div class="min-w-0">

                    <p
                        id="delete-document-name"
                        class="
                            text-sm
                            font-bold
                            text-slate-700
                            dark:text-slate-200
                            truncate
                        "
                    >
                        -
                    </p>

                    <p
                        id="delete-document-file-name"
                        class="
                            mt-1
                            text-xs
                            text-slate-500
                            dark:text-slate-400
                            truncate
                        "
                    >
                        -
                    </p>

                </div>

            </div>


            <p
                class="
                    mt-5
                    text-sm
                    text-slate-600
                    dark:text-slate-300
                "
            >
                ¿Estás segura de que deseas enviar este documento a la papelera?
            </p>

            <p
                class="
                    mt-2
                    text-xs
                    text-slate-400
                    dark:text-slate-500
                "
            >
                El archivo no será eliminado físicamente y podrá restaurarse
                desde la papelera.
            </p>

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
            "
        >

            {{-- CANCELAR --}}
            <button
                type="button"
                id="cancel-document-delete-modal"
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


            {{-- CONFIRMAR --}}
            <form
                id="document-delete-form"
                method="POST"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="
                        px-5
                        py-2.5
                        rounded-xl
                        bg-red-600
                        hover:bg-red-700
                        text-white
                        font-semibold
                        transition
                    "
                >
                    🗑️ Enviar a papelera
                </button>

            </form>

        </div>

    </div>

</div>