{{-- MODAL MOVER CARPETA --}}

<div
    id="category-move-modal"
    class="
        hidden
        fixed
        inset-0
        z-[80]
        items-center
        justify-center
        bg-black/60
        backdrop-blur-sm
        px-4
    "
>
    <div
        class="
            w-full
            max-w-lg
            rounded-2xl
            bg-white
            dark:bg-slate-900
            shadow-2xl
            border
            border-slate-200
            dark:border-slate-700
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
                dark:border-slate-700
            "
        >
            <div>
                <h2
                    class="
                        text-lg
                        font-bold
                        text-slate-800
                        dark:text-white
                    "
                >
                    Mover carpeta
                </h2>

                <p
                    class="
                        mt-1
                        text-sm
                        text-slate-500
                        dark:text-slate-400
                    "
                >
                    Selecciona la nueva ubicación.
                </p>
            </div>

            <button
                type="button"
                id="close-category-move-modal"
                class="
                    w-9
                    h-9
                    rounded-xl
                    flex
                    items-center
                    justify-center
                    text-slate-400
                    hover:text-slate-700
                    hover:bg-slate-100
                    dark:hover:bg-slate-800
                    dark:hover:text-white
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
                    bg-slate-100
                    dark:bg-slate-800
                    px-4
                    py-3
                    mb-5
                "
            >
                <p
                    class="
                        text-xs
                        text-slate-500
                        dark:text-slate-400
                    "
                >
                    Carpeta seleccionada
                </p>

                <p
                    id="category-move-name"
                    class="
                        mt-1
                        text-sm
                        font-semibold
                        text-slate-800
                        dark:text-white
                    "
                >
                </p>
            </div>

            <form
                id="category-move-form"
                method="POST"
            >
                @csrf

                @method('PATCH')

                <label
                    for="category-move-parent"
                    class="
                        block
                        text-sm
                        font-semibold
                        text-slate-700
                        dark:text-slate-200
                        mb-2
                    "
                >
                    Mover a
                </label>

                <select
                    id="category-move-parent"
                    name="parent_id"
                    class="
                        w-full
                        rounded-xl
                        border
                        border-slate-300
                        dark:border-slate-700
                        bg-white
                        dark:bg-slate-950
                        text-slate-700
                        dark:text-slate-200
                        px-4
                        py-3
                        outline-none
                        focus:border-blue-500
                        focus:ring-2
                        focus:ring-blue-500/20
                    "
                >
                    <option value="">
                        📁 Carpeta Raíz / Sin carpeta
                    </option>
                </select>

                <p
                    id="category-move-loading"
                    class="
                        hidden
                        mt-3
                        text-sm
                        text-slate-500
                        dark:text-slate-400
                    "
                >
                    Cargando carpetas...
                </p>

                <p
                    id="category-move-error"
                    class="
                        hidden
                        mt-3
                        text-sm
                        text-red-600
                        dark:text-red-400
                    "
                ></p>

                {{-- BOTONES --}}
                <div
                    class="
                        flex
                        justify-end
                        gap-3
                        mt-6
                    "
                >
                    <button
                        type="button"
                        id="cancel-category-move-modal"
                        class="
                            px-4
                            py-2.5
                            rounded-xl
                            bg-slate-200
                            dark:bg-slate-800
                            text-slate-700
                            dark:text-slate-200
                            text-sm
                            font-semibold
                            hover:bg-slate-300
                            dark:hover:bg-slate-700
                            transition
                        "
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        id="submit-category-move"
                        class="
                            px-4
                            py-2.5
                            rounded-xl
                            bg-blue-600
                            hover:bg-blue-700
                            text-white
                            text-sm
                            font-semibold
                            transition
                        "
                    >
                        📂 Mover carpeta
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>