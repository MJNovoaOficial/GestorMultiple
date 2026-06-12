<x-app-layout>
    <div class="p-6">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-700 dark:text-slate-200">
                Nuevo Dvr
            </h1>

            <p class="text-slate-500 dark:text-slate-400 mt-1">
                Registrar nuevo DVR.
            </p>
        </div>

        <div class="
            rounded-2xl
            border
            border-slate-200
            dark:border-slate-800
            bg-white
            dark:bg-[#020817]
            p-6
        ">
            <form
                action="{{ route('dvrs.store') }}"
                method="POST"
            >
                @csrf

                @include('dvrs.form')

                <div class="
                    mt-8
                    flex
                    justify-end
                    gap-3
                ">
                    <a
                        href="{{ route('dvrs.index') }}"
                        class="
                            px-5 py-3
                            rounded-xl
                            bg-slate-600
                            hover:bg-slate-700
                            text-white
                            font-semibold
                        "
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="
                            px-5 py-3
                            rounded-xl
                            bg-green-600
                            hover:bg-green-700
                            text-white
                            font-semibold
                        "
                    >
                        Guardar
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>