<x-app-layout>

    <div class="mb-8">

        <h1 class="
            text-3xl font-bold
            text-slate-900 dark:text-white
        ">
            Mi perfil 👤
        </h1>

        <p class="
            mt-2
            text-slate-600 dark:text-slate-400
        ">
            Administra tu información personal y seguridad.
        </p>

    </div>

    <div class="
        grid grid-cols-1
        gap-6
    ">

        {{-- INFORMACIÓN PERFIL --}}
        <div class="
            bg-white dark:bg-[#0F172A]
            border border-slate-200 dark:border-slate-800
            rounded-2xl
            p-6 max-w-3xl
            shadow-sm
        ">

            <div>

                @include(
                    'profile.partials.update-profile-information-form'
                )

            </div>

        </div>

        {{-- CAMBIAR PASSWORD --}}
        <div class="
            bg-white dark:bg-[#0F172A]
            border border-slate-200 dark:border-slate-800
            rounded-2xl
            p-6 max-w-3xl
            shadow-sm
        ">

            <div>

                @include(
                    'profile.partials.update-password-form'
                )

            </div>

        </div>

        {{-- ELIMINAR CUENTA --}}
        <div class="
            bg-white dark:bg-[#0F172A]
            border border-red-200 dark:border-red-900/40
            rounded-2xl
            p-6 max-w-3xl
            shadow-sm
        ">

            <div>

                @include(
                    'profile.partials.delete-user-form'
                )

            </div>

        </div>

    </div>

</x-app-layout>
