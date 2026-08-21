{{-- Modal: Nueva categoría --}}

<div
    id="category-modal"
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

    {{-- Contenedor --}}
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
                        Nueva categoría
                    </h2>

                    <p
                        class="
                            mt-1
                            text-sm
                            text-slate-500
                            dark:text-slate-400
                        "
                    >
                        Crea una categoría para organizar tus documentos.
                    </p>
                </div>

                <button
                    type="button"
                    id="close-category-modal"
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


            {{-- FORMULARIO --}}
            <form
                method="POST"
                action="{{ route('documentacion.store') }}"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="p-6 space-y-5">

                    {{-- NOMBRE --}}
                    <div>

                        <label
                            for="category-name"
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
                            id="category-name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            placeholder="Ej: SAP"
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

                        @error('name')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- DESCRIPCIÓN --}}
                    <div>

                        <label
                            for="category-description"
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
                            id="category-description"
                            name="description"
                            rows="3"
                            placeholder="Describe brevemente esta categoría..."
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
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- IMAGEN --}}
                    <div>

                        <label
                            for="category-image"
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

                        <input
                            type="file"
                            id="category-image"
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
                                transition
                            "
                        >

                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                            Opcional. Si no seleccionas una imagen, se utilizará la imagen genérica.
                        </p>

                        @error('image')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror


                        {{-- PREVISUALIZACIÓN --}}
                        <div
                            id="category-image-preview-container"
                            class="hidden mt-4"
                        >

                            <p
                                class="
                                    text-xs
                                    font-semibold
                                    text-slate-500
                                    dark:text-slate-400
                                    mb-2
                                "
                            >
                                Vista previa
                            </p>

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
                                    id="category-image-preview"
                                    src=""
                                    alt="Vista previa"
                                    class="w-full h-full object-contain p-2"
                                >

                            </div>

                        </div>

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
                        id="cancel-category-modal"
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
                            bg-green-600
                            hover:bg-green-700
                            text-white
                            font-semibold
                            transition
                        "
                    >
                        Crear categoría
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- JAVASCRIPT DEL MODAL --}}
<script>

    document.addEventListener('DOMContentLoaded', () => {

        const modal = document.getElementById('category-modal');
        const openButton = document.getElementById('open-category-modal');
        const closeButton = document.getElementById('close-category-modal');
        const cancelButton = document.getElementById('cancel-category-modal');

        if (!modal || !openButton) {
            return;
        }


        // Abrir modal
        openButton.addEventListener('click', () => {

            modal.classList.remove('hidden');
            modal.classList.add('flex');

        });


        // Cerrar con X
        if (closeButton) {

            closeButton.addEventListener('click', () => {

                closeModal();

            });

        }


        // Cerrar con Cancelar
        if (cancelButton) {

            cancelButton.addEventListener('click', () => {

                closeModal();

            });

        }


        // Cerrar haciendo click fuera del modal
        modal.addEventListener('click', (event) => {

            if (event.target === modal) {

                closeModal();

            }

        });


        function closeModal() {

            modal.classList.add('hidden');
            modal.classList.remove('flex');

        }

    });

</script>