{{-- Modal: Restaurar categoría --}}

<div
    id="category-restore-modal"
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

    <div class="relative w-full max-w-md">

        <div
            class="
                relative
                w-full
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
                        Restaurar categoría
                    </h2>

                    <p
                        class="
                            mt-1
                            text-sm
                            text-slate-500
                            dark:text-slate-400
                        "
                    >
                        La categoría volverá a estar disponible.
                    </p>

                </div>


                {{-- CERRAR --}}
                <button
                    type="button"
                    id="close-category-restore-modal"
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
                        rounded-xl
                        border
                        border-blue-200
                        dark:border-blue-900/50
                        bg-blue-50
                        dark:bg-blue-950/20
                        p-4
                    "
                >

                    <div class="flex items-start gap-3">

                        <div
                            class="
                                w-10
                                h-10
                                rounded-xl
                                bg-blue-100
                                dark:bg-blue-900/40
                                flex
                                items-center
                                justify-center
                                flex-shrink-0
                            "
                        >
                            ♻️
                        </div>


                        <div>

                            <p
                                class="
                                    text-sm
                                    font-semibold
                                    text-blue-700
                                    dark:text-blue-400
                                "
                            >
                                ¿Estás segura de restaurar esta categoría?
                            </p>

                            <p
                                id="category-restore-name"
                                class="
                                    mt-1
                                    text-base
                                    font-bold
                                    text-slate-700
                                    dark:text-slate-200
                                "
                            >
                                —
                            </p>

                            <p
                                class="
                                    mt-2
                                    text-sm
                                    text-slate-600
                                    dark:text-slate-400
                                "
                            >
                                La categoría volverá a aparecer en
                                Documentación con toda su información.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FORMULARIO --}}
            <form
                id="category-restore-form"
                method="POST"
            >

                @csrf
                @method('PATCH')

                {{-- FOOTER --}}
                <div
                    class="
                        flex
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
                        id="cancel-category-restore-modal"
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


                    {{-- RESTAURAR --}}
                    <button
                        type="submit"
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
                        ♻️ Restaurar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>