<x-app-layout>

    <div class="py-8">

        <div class="w-full max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}

            <div class="mb-8">

                <h1 class="
                    text-3xl
                    font-bold
                    text-white
                ">
                    Nuevo Registro
                </h1>

                <p class="
                    mt-1
                    text-sm
                    text-slate-400
                ">
                    Registrar nuevo Notebook corporativo
                </p>

            </div>

            {{-- CARD --}}

            <div class="
                rounded-2xl

                border
                border-slate-800

                bg-[#020817]

                p-8
            ">

                <form
                    action="{{ route('notebooks.store') }}"
                    method="POST"
                >                

                    @include('notebooks.form', [
                        'device' => null
                    ])

                    {{-- BOTONES --}}

                    <div class="
                        mt-8

                        flex
                        items-center
                        justify-end

                        gap-3
                    ">

                        <a
                            href="{{ route('notebooks.index') }}"

                            class="
                                px-5 py-3

                                rounded-xl

                                bg-slate-800
                                hover:bg-slate-700

                                text-white
                                text-sm
                                font-semibold

                                transition
                            "
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"

                            class="
                                px-5 py-3

                                rounded-xl

                                bg-indigo-600
                                hover:bg-indigo-700

                                text-white
                                text-sm
                                font-semibold

                                transition
                            "
                        >
                            Guardar Registro
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <style>
    /* Chrome, Edge, Opera */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
    </style>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            flatpickr("#delivery_date", {

                 locale: Spanish,

                altInput: true,

                altFormat: "d F Y",

                dateFormat: "Y-m-d",

                allowInput: false,

                disableMobile: true,
            });

        });

        function formatRut(rut) {

            // Limpiar caracteres
            rut = rut.replace(/[^0-9kK]/g, '');

            if (rut.length < 2) {
                return rut;
            }

            let body = rut.slice(0, -1);
            let dv = rut.slice(-1).toUpperCase();

            // Formatear miles
            body = body.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            return `${body}-${dv}`;
        }
    
        document.getElementById('purchase_value')
        .addEventListener('input', function () {

            let value = this.value.replace(/\D/g, '');

            this.value = new Intl.NumberFormat(
                'es-CL'
            ).format(value);

        });

        document.addEventListener('DOMContentLoaded', () => {

            const rutInput = document.getElementById('user_rut');

            rutInput.addEventListener('blur', () => {

                rutInput.value = formatRut(rutInput.value);

            });

        });

    </script>
</x-app-layout>