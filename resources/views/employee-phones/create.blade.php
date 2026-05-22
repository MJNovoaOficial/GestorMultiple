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
                    Registrar nuevo celular corporativo
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
                    action="{{ route('employee-phones.store') }}"
                    method="POST"
                >

                    @include('employee-phones.form', [
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
                            href="{{ route('employee-phones.index') }}"

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

        document.addEventListener('DOMContentLoaded', () => {

            const rutInput = document.getElementById('rut');

            rutInput.addEventListener('blur', () => {

                rutInput.value = formatRut(rutInput.value);

            });

        });

        document.addEventListener('DOMContentLoaded', () => {

        const phoneInput = document.getElementById('phone_number');

        const phoneError = document.getElementById('phone-error');

        phoneInput.addEventListener('input', () => {

            // Solo números
            phoneInput.value = phoneInput.value.replace(/\D/g, '');

            // Máximo 9
            phoneInput.value = phoneInput.value.slice(0, 9);

            // Validación visual
            if (phoneInput.value.length > 0 && phoneInput.value.length < 9) {

                phoneError.classList.remove('hidden');

            } else {

                phoneError.classList.add('hidden');

            }

        });

    });


    </script>
</x-app-layout>