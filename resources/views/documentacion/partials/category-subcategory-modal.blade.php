{{-- MODAL NUEVA SUBCARPETA --}}
<div
    id="subcategory-modal"
    class="hidden fixed inset-0 z-[70] items-center justify-center bg-black/60 backdrop-blur-sm px-4"
>
    <div
        class="
            w-full
            max-w-lg
            rounded-2xl
            border
            border-slate-200
            dark:border-slate-800
            bg-white
            dark:bg-[#020817]
            shadow-2xl
            overflow-hidden
        "
    >

        {{-- ENCABEZADO --}}
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
                <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                    Nueva subcarpeta
                </h2>

                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Se creará dentro de:
                    <span class="font-semibold text-blue-600 dark:text-blue-400">
                        {{ $category->name }}
                    </span>
                </p>
            </div>

            {{-- CERRAR --}}
            <button
                type="button"
                id="close-subcategory-modal"
                class="
                    w-9
                    h-9
                    rounded-xl
                    flex
                    items-center
                    justify-center
                    text-slate-400
                    hover:text-slate-600
                    hover:bg-slate-100
                    dark:hover:bg-slate-800
                    dark:hover:text-slate-200
                    transition
                "
            >
                ✕
            </button>
        </div>

        {{-- FORMULARIO --}}
        <form
            id="subcategory-form"
            method="POST"
            action="{{ route('documentacion.store') }}"
        >
            @csrf

            {{-- PADRE --}}
            <input
                type="hidden"
                name="parent_id"
                value="{{ $category->id }}"
            >

            <div class="px-6 py-6 space-y-5">

                {{-- NOMBRE --}}
                <div>
                    <label
                        for="subcategory-name"
                        class="
                            block
                            text-sm
                            font-semibold
                            text-slate-700
                            dark:text-slate-200
                            mb-2
                        "
                    >
                        Nombre de la subcarpeta
                    </label>

                    <input
                        type="text"
                        id="subcategory-name"
                        name="name"
                        required
                        maxlength="255"
                        autocomplete="off"
                        placeholder="Ej: Proyecto EWM LA03"
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
                            placeholder-slate-400
                            px-4
                            py-3
                            text-sm
                            outline-none
                            focus:border-blue-500
                            focus:ring-2
                            focus:ring-blue-500/20
                            transition
                        "
                    >
                </div>

                {{-- DESCRIPCIÓN --}}
                <div>
                    <label
                        for="subcategory-description"
                        class="
                            block
                            text-sm
                            font-semibold
                            text-slate-700
                            dark:text-slate-200
                            mb-2
                        "
                    >
                        Descripción
                        <span class="font-normal text-slate-400">
                            (opcional)
                        </span>
                    </label>

                    <textarea
                        id="subcategory-description"
                        name="description"
                        rows="3"
                        maxlength="1000"
                        placeholder="Descripción de la subcarpeta..."
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
                            placeholder-slate-400
                            px-4
                            py-3
                            text-sm
                            outline-none
                            focus:border-blue-500
                            focus:ring-2
                            focus:ring-blue-500/20
                            transition
                            resize-none
                        "
                    ></textarea>
                </div>

            </div>

            {{-- PIE --}}
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
                    dark:bg-slate-950/50
                "
            >
                <button
                    type="button"
                    id="cancel-subcategory-modal"
                    class="
                        px-4
                        py-2.5
                        rounded-xl
                        text-sm
                        font-semibold
                        text-slate-600
                        dark:text-slate-300
                        hover:bg-slate-200
                        dark:hover:bg-slate-800
                        transition
                    "
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="
                        inline-flex
                        items-center
                        gap-2
                        px-4
                        py-2.5
                        rounded-xl
                        bg-blue-600
                        hover:bg-blue-700
                        text-sm
                        font-semibold
                        text-white
                        transition
                    "
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

                    Crear subcarpeta
                </button>
            </div>

        </form>
    </div>
</div>