<x-app-layout>

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
            Bienvenido nuevamente,
            {{ auth()->user()->name }} 👋
        </h1>

        <p class="mt-2 text-slate-600 dark:text-slate-400">
            Este es el resumen operativo actual de tu plataforma MultiGestor.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">

    {{-- Sucursales --}}
    <div class="
        bg-white dark:bg-[#111827]
        border border-slate-200 dark:border-slate-800
        rounded-2xl
        flex flex-col justify-center
        shadow-sm dark:shadow-none
    ">
        <p class="
            text-sm text-center
            font-semibold
            tracking-wide
            text-slate-700 dark:text-slate-300
            uppercase
        ">
            Sucursales
        </p>

        <h2 class="mt-3 text-4xl font-bold text-center">
            {{ $totalBranches }}
        </h2>
    </div>

    {{-- Total IPs --}}
    <div class="
        bg-white dark:bg-[#111827]
        border border-slate-200 dark:border-slate-800
        rounded-2xl
        flex flex-col justify-center
        shadow-sm dark:shadow-none
    ">
        <p class="
            text-sm text-center
            font-semibold
            tracking-wide
            text-slate-700 dark:text-slate-300
            uppercase
        ">
            Total IPs
        </p>

        <h2 class="mt-3 text-4xl font-bold text-center">
            {{ $totalIps }}
        </h2>
    </div>

    {{-- Disponibles --}}
    <div class="
        bg-white dark:bg-[#111827]
        border border-slate-200 dark:border-slate-800
        rounded-2xl
        flex flex-col justify-center
        shadow-sm dark:shadow-none
    ">
        <p class="
            text-sm text-center
            font-semibold
            tracking-wide
            text-slate-700 dark:text-slate-300
            uppercase
        ">
            IPs disponibles
        </p>

        <h2 class="mt-3 text-4xl font-bold text-green-500 text-center">
            {{ $availableIps }}
        </h2>
    </div>

    {{-- Asignadas --}}
    <div class="
        bg-white dark:bg-[#111827]
        border border-slate-200 dark:border-slate-800
        rounded-2xl
        flex flex-col justify-center
        shadow-sm dark:shadow-none
    ">
        <p class="
            text-sm text-center
            font-semibold
            tracking-wide
            text-slate-700 dark:text-slate-300
            uppercase
        ">
            IPs asignadas
        </p>

        <h2 class="mt-3 text-4xl font-bold text-blue-500 text-center">
            {{ $assignedIps }}
        </h2>
    </div>

</div>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

    {{-- Usuarios activos --}}
    <div class="
        bg-white dark:bg-[#111827]
        border border-slate-200 dark:border-slate-800
        rounded-2xl
        flex flex-col justify-center
        shadow-sm dark:shadow-none
    ">
        <p class="
            text-sm text-center
            font-semibold
            tracking-wide
            text-slate-700 dark:text-slate-300
            uppercase
        ">
            Usuarios activos
        </p>

        <h2 class="mt-3 text-4xl font-bold text-center">
            {{ $activeUsers }}
        </h2>
    </div>

    {{-- Usuarios con password --}}
    <div class="
        bg-white dark:bg-[#111827]
        border border-slate-200 dark:border-slate-800
        rounded-2xl
        flex flex-col justify-center
        shadow-sm dark:shadow-none
    ">
        <p class="
            text-sm text-center
            font-semibold
            tracking-wide
            text-slate-700 dark:text-slate-300
            uppercase
        ">
            Usuarios con contraseña
        </p>

        <h2 class="mt-3 text-4xl font-bold text-center">
            {{ $usersWithPasswords }}
        </h2>
    </div>

    {{-- Cobertura --}}
    <div class="
        bg-white dark:bg-[#111827]
        border border-slate-200 dark:border-slate-800
        rounded-2xl
        flex flex-col justify-center
        shadow-sm dark:shadow-none
    ">
        <p class="
            text-sm text-center
            font-semibold
            tracking-wide
            text-slate-700 dark:text-slate-300
            uppercase
        ">
            Cobertura passwords
        </p>

        <h2 class="mt-3 text-4xl font-bold text-amber-500 text-center">
            {{ $passwordCoverage }}%
        </h2>
    </div>

    <div class="
        bg-white dark:bg-[#111827]
        border border-slate-200 dark:border-slate-800
        rounded-2xl
        flex flex-col justify-center
        shadow-sm dark:shadow-none
    ">

    <p class="
        text-sm text-center
        font-semibold
        tracking-wide
        text-slate-700 dark:text-slate-300
        uppercase
    ">
        Última auditoría
    </p>

    @if($lastAudit)

        <div class="space-y-1">

            <h3 class="text-lg text-center font-semibold leading-snug">
                {{ $lastAudit->description ?? 'Actividad registrada' }}
            </h3>

            @if($lastAudit->user)

                <p class="text-sm text-center text-slate-500 dark:text-slate-400">
                    Realizado por
                    <span class="font-medium">
                        {{ $lastAudit->user->name }}
                    </span>
                </p>

            @endif

            <p class="text-sm text-center text-slate-500 dark:text-slate-400">
                {{ $lastAudit->created_at->diffForHumans() }}
            </p>

        </div>

    @else

        <p class="text-sm text-center text-slate-500 dark:text-slate-400">
            No hay registros de auditoría.
        </p>

    @endif

    </div>

</div>
</x-app-layout>