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

    {{-- primera fila --}}
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

    {{-- segunda fila --}}
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
                Contraseñas de Correo Generadas
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
                Dispositivos Registrados
            </p>

            <div class="stat-value text-center text-blue-500 text-warning">
                {{ number_format($totalDevices) }}
            </div>

            <div class="small text-muted font-semibold text-center mt-2">
                C: {{ $totalCellphones }}
                &nbsp;•&nbsp;
                N: {{ $totalNotebooks }}
                &nbsp;•&nbsp;
                RF: {{ $totalRadiofrequencies }}
                &nbsp;•&nbsp;
                DVR: {{ $totalDvrs }}
            </div>
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

    {{-- Tercera fila --}}
    <div class="
        mt-8
        grid grid-cols-1
        md:grid-cols-3
        gap-6
        ">

        {{-- STOCK BAJO --}}
        <a
            href="{{ route('supplies.index', [
                'filter' => 'critical'
            ]) }}"
            class="
                block
                bg-yellow-100 dark:bg-yellow-500/10
                border-yellow-300 dark:border-yellow-500/20
                text-yellow-800 dark:text-yellow-300
                rounded-2xl
                p-6
                hover:bg-yellow-500/20
                transition
                text-center
                flex
                flex-col
                justify-center
            "
        >

            <p class="
                text-sm font-bold uppercase
                text-yellow-700 dark:text-yellow-300
            ">
                Stock crítico
            </p>

            <h2 class="
                mt-3 text-4xl font-bold
                text-yellow-800 dark:text-yellow-200
            ">
                {{ $lowStockSupplies }}
            </h2>

            <p class="
                mt-2 text-sm
                text-yellow-700 dark:text-yellow-400
            ">
                suministros con stock bajo
            </p>

        </a>

        {{-- SIN STOCK --}}
        <a
            href="{{ route('supplies.index', [
                'filter' => 'out'
            ]) }}"
            class="
                block
                bg-red-100 dark:bg-red-500/10
                border-red-300 dark:border-red-500/20
                text-red-800 dark:text-red-300
                rounded-2xl
                p-6
                hover:bg-red-500/20
                transition
                text-center
                flex
                flex-col
                justify-center
            "
        >

            <p class="
                text-sm font-bold uppercase
                text-red-700 dark:text-red-300
            ">
                Sin stock
            </p>

            <h2 class="
                mt-3 text-4xl font-bold
                text-red-800 dark:text-red-200
            ">
                {{ $outOfStockSupplies }}
            </h2>

            <p class="
                mt-2 text-sm
                text-red-700 dark:text-red-400
            ">
                suministros agotados
            </p>

        </a>

        {{-- ÚLTIMO MOVIMIENTO --}}
        <div class="
                bg-blue-100 dark:bg-blue-500/10
                border-blue-300 dark:border-blue-500/20
                text-blue-800 dark:text-blue-300
                rounded-2xl
                p-6
                h-full
                text-center
                flex
                flex-col
                justify-center
            ">
                @if($lastSupplyMovement)

                @php

                    $isAdd = $lastSupplyMovement->type === 'add';

                @endphp

                <div class="mt-4">

                    <p class="
                        text-sm font-semibold
                        {{ $isAdd
                            ? 'text-green-400'
                            : 'text-red-400'
                        }}
                    ">

                        {{ $isAdd ? '⬆ Stock agregado' : '⬇ Stock descontado' }}

                    </p>

                    <h2 class="
                        mt-2 text-xl font-bold
                        text-slate-900 dark:text-white
                    ">

                        {{ $lastSupplyMovement->supply?->supply_type }}

                    </h2>

                    <p class="
                        mt-2 text-lg
                        text-slate-600 dark:text-slate-400
                    ">
                        +{{ $lastSupplyMovement->quantity }} unidades
                    </p>

                    <p class="
                        mt-4 text-sm
                        text-slate-400
                    ">

                        {{ $lastSupplyMovement->created_at->diffForHumans() }}

                    </p>

                    <p class="
                        text-sm
                        text-slate-500
                    ">

                        por
                        {{ $lastSupplyMovement->user?->name ?? 'Sistema' }}

                    </p>

                </div>

            @endif
        </div>
    </div>

</x-app-layout>