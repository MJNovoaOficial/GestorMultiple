{{-- Modal: Editar categoría --}}

<div
    id="category-edit-modal"
    class="
        hidden
        fixed
        inset-0
        z-50
        bg-black/60
        items-center
        justify-center
        p-4
        overflow-y-auto
    "
>

    <div class="relative w-full max-w-2xl">

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
                        Editar categoría
                    </h2>

                    <p
                        class="
                            mt-1
                            text-sm
                            text-slate-500
                            dark:text-slate-400
                        "
                    >
                        Modifica la información de esta categoría.
                    </p>
                </div>

                <button
                    type="button"
                    id="close-category-edit-modal"
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


            {{-- FORMULARIO --}}
            <form
                id="category-edit-form"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')

                <div class="p-6 space-y-5">

                    {{-- NOMBRE --}}
                    <div>

                        <label
                            for="edit-category-name"
                            class="
                                block
                                mb-2
                                text-sm
                                font-semibold
                                text-slate-700
                                dark:text-slate-300
                            "
                        >
                            Nombre
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="edit-category-name"
                            name="name"
                            required
                            class="
                                w-full
                                rounded-xl
                                border
                                border-slate-300
                                dark:border-slate-700
                                bg-white
                                dark:bg-slate-900
                                px-4
                                py-3
                                text-slate-700
                                dark:text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                        >

                    </div>


                    {{-- DESCRIPCIÓN --}}
                    <div>

                        <label
                            for="edit-category-description"
                            class="
                                block
                                mb-2
                                text-sm
                                font-semibold
                                text-slate-700
                                dark:text-slate-300
                            "
                        >
                            Descripción
                        </label>

                        <textarea
                            id="edit-category-description"
                            name="description"
                            rows="3"
                            class="
                                w-full
                                rounded-xl
                                border
                                border-slate-300
                                dark:border-slate-700
                                bg-white
                                dark:bg-slate-900
                                px-4
                                py-3
                                text-slate-700
                                dark:text-white
                                focus:outline-none
                                focus:ring-2
                                focus:ring-blue-500
                            "
                        ></textarea>

                    </div>


                    {{-- IMAGEN ACTUAL --}}
                    <div>

                        <label
                            class="
                                block
                                mb-2
                                text-sm
                                font-semibold
                                text-slate-700
                                dark:text-slate-300
                            "
                        >
                            Imagen de la categoría
                        </label>

                        <div class="flex items-center gap-4">

                            <div
                                class="
                                    w-24
                                    h-24
                                    rounded-2xl
                                    border
                                    border-slate-200
                                    dark:border-slate-700
                                    bg-slate-100
                                    dark:bg-slate-900
                                    flex
                                    items-center
                                    justify-center
                                    overflow-hidden
                                "
                            >

                                <img
                                    id="edit-category-image-preview"
                                    src="{{ asset('images/documentacion/default-category.png') }}"
                                    alt="Imagen de categoría"
                                    class="w-full h-full object-contain p-2"
                                >

                            </div>

                            <div class="flex-1">

                                <input
                                    type="file"
                                    id="edit-category-image"
                                    name="image"
                                    accept="image/jpeg,image/png,image/webp,image/gif"
                                    class="
                                        block
                                        w-full
                                        rounded-xl
                                        border
                                        border-slate-300
                                        dark:border-slate-700
                                        bg-white
                                        dark:bg-slate-900
                                        text-sm
                                        text-slate-600
                                        dark:text-slate-300
                                        file:mr-4
                                        file:py-2.5
                                        file:px-4
                                        file:rounded-xl
                                        file:border-0
                                        file:bg-blue-600
                                        file:text-white
                                        file:font-semibold
                                        hover:file:bg-blue-700
                                    "
                                >

                                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                    Puedes seleccionar una nueva imagen para reemplazar la actual.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- QUITAR IMAGEN --}}
                    <div
                        id="remove-category-image-container"
                        class="hidden"
                    >

                        <label class="inline-flex items-center gap-2">

                            <input
                                type="checkbox"
                                id="remove-category-image"
                                name="remove_image"
                                value="1"
                                class="
                                    rounded
                                    border-slate-300
                                    text-red-600
                                    focus:ring-red-500
                                "
                            >

                            <span
                                class="
                                    text-sm
                                    text-red-600
                                    dark:text-red-400
                                "
                            >
                                Quitar imagen personalizada y usar la imagen genérica
                            </span>

                        </label>

                    </div>

                </div>


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

                    <button
                        type="button"
                        id="cancel-category-edit-modal"
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
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>