<x-app-layout>

    <div class="p-6">

        {{-- Header --}}
        <div class="mb-6">

            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                Gestor de IPs
            </h1>

            <p class="text-slate-500 dark:text-slate-400 mt-1">
                Administración de direcciones IP del sistema
            </p>

        </div>

        @php
            $colors = [
                'green' => 'bg-green-500',
                'blue' => 'bg-blue-500',
                'yellow' => 'bg-yellow-500',
                'red' => 'bg-red-500',
                'orange' => 'bg-orange-500',
            ];
        @endphp

        {{-- Toolbar filtros --}}
        <div
            class="bg-[#0F172A]
                   border border-gray-800
                   rounded-2xl
                   p-4 mb-6
                   shadow-lg"
        >

            <div class="flex flex-col gap-4">

                {{-- Top row --}}
                <div class="flex items-center gap-4 flex-wrap">

                    <div class="text-sm font-medium text-gray-400">
                        Filtrar sucursal
                    </div>

                    <form
                        id="branchFilterForm"
                        method="GET"
                        action="{{ route('ip-addresses.index') }}"
                        class="flex items-center gap-4 flex-wrap"
                    >

                        <select
                            name="branch_id"
                            onchange="document.getElementById('branchFilterForm').submit()"
                            class="
                                min-w-[240px]
                                bg-[#1E293B]
                                border border-gray-700
                                text-white
                                rounded-xl
                                px-4 py-2.5
                                text-sm
                                focus:ring-2 focus:ring-indigo-500
                                focus:border-indigo-500
                            "
                        >

                            <option value="">
                                Todas las sucursales
                            </option>

                            @foreach($branches as $branch)

                                <option
                                    value="{{ $branch->id }}"
                                    {{ request('branch_id') == $branch->id ? 'selected' : '' }}
                                >
                                    {{ $branch->name }}
                                </option>

                            @endforeach

                        </select>

                        <div>
                            <select
                                id="statusFilter"
                                class="
                                    min-w-[240px]
                                    bg-[#1E293B]
                                    border border-gray-700
                                    text-white
                                    rounded-xl
                                    px-4 py-2.5
                                    text-sm
                                    focus:ring-2 focus:ring-indigo-500
                                    focus:border-indigo-500
                                "
                            >
                                <option value="">
                                    Todos los estados
                                </option>

                                @foreach($ipStatuses as $status)

                                    <option value="{{ strtolower($status->name) }}">
                                        {{ $status->name }}
                                    </option>

                                @endforeach

                            </select>
                        </div>

                        <input
                            type="text"
                            id="globalSearch"
                            placeholder="Buscar IP, usuario, dispositivo, sucursal..."
                            class="
                                w-full md:w-96
                                bg-[#1E293B]
                                border border-gray-700
                                text-white
                                rounded-xl
                                px-4 py-3
                                text-sm
                                focus:ring-2 focus:ring-indigo-500
                                focus:border-indigo-500
                            "
                        >

                    </form>

                </div>

                {{-- Subnets --}}
                @if($subnets->count())

                    <div class="flex flex-wrap gap-2">

                        @foreach($subnets as $subnet)

                            <a
                                href="{{ route('ip-addresses.index', array_merge(
                                    request()->query(),
                                    ['subnet' => $subnet]
                                )) }}"
                                class="
                                    px-4 py-2
                                    rounded-xl
                                    text-sm
                                    font-medium
                                    transition

                                    {{ request('subnet') === $subnet
                                        ? 'bg-indigo-600 text-white shadow-lg'
                                        : 'bg-[#1E293B] text-gray-300 hover:bg-gray-700'
                                    }}
                                "
                            >
                                {{ $subnet }}.x
                            </a>

                        @endforeach

                    </div>

                @endif

            </div>

        </div>

        {{-- Tabla --}}
        <div class="bg-[#020817] rounded-2xl overflow-hidden shadow-xl">

            <table class="w-full">

                {{-- Header --}}
                <thead class="bg-[#1E293B] text-white">

                    <tr>

                        <th class="px-6 py-4 text-left">
                            IP
                        </th>

                        <th class="px-6 py-4 text-center">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-center">
                            Usuario Responsable
                        </th>

                        <th class="px-6 py-4 text-center">
                            Dispositivo
                        </th>

                        <th class="px-6 py-4 text-center">
                            Sucursal
                        </th>

                        <th class="px-6 py-4 text-center">
                            Departamento
                        </th>

                        <th class="px-6 py-4 text-center">
                            Acciones
                        </th>

                    </tr>

                </thead>

                {{-- Body --}}
                <tbody>

                    @forelse($ipAddresses as $ip)

                        <tr data-status="{{ strtolower($ip->ipStatus->name) }}"
                            x-data="{ editing: false }"

                            data-search="{{ strtolower(
                                $ip->ip_address . ' ' .
                                ($ip->ipStatus?->name ?? '') . ' ' .
                                ($ip->user_assigned ?? '') . ' ' .
                                ($ip->deviceType?->name ?? '') . ' ' .
                                ($ip->branch?->name ?? '') . ' ' .
                                ($ip->department?->name ?? '')
                            ) }}"

                            class="ip-row border-b border-gray-800 hover:bg-[#0F172A] transition"
                        >

                            {{-- IP --}}
                            <td class="px-6 py-4 text-white font-medium">
                                {{ $ip->ip_address }}
                            </td>

                            {{-- Estado --}}
                            <td class="px-6 py-4 text-center">

                                <span class="
                                    {{ $colors[$ip->ipStatus->color] ?? 'bg-gray-500' }}
                                    text-white
                                    px-3 py-1
                                    rounded-full
                                    text-sm
                                ">
                                    {{ $ip->ipStatus->name }}
                                </span>

                            </td>

                            {{-- Usuario Responsable --}}
                            <td class="px-6 py-4 text-center text-gray-300">

                                <template x-if="!editing">

                                    <div>

                                        @if ($ip->user_assigned)

                                            {{ $ip->user_assigned }}

                                        @else

                                            <span class="text-gray-500 italic">
                                                Sin asignación
                                            </span>

                                        @endif

                                    </div>

                                </template>

                                <template x-if="editing">

                                    <div>

                                        <input
                                            type="text"
                                            name="user_assigned"
                                            value="{{ $ip->user_assigned }}"
                                            placeholder="Usuario responsable"
                                            form="form-{{ $ip->id }}"
                                            class="
                                                bg-[#1E293B]
                                                border border-gray-700
                                                rounded-lg
                                                px-3 py-2
                                                text-white
                                                text-sm
                                                w-52
                                            "
                                        >

                                    </div>

                                </template>

                            </td>

                            {{-- Tipo de dispositivo --}}
                            <td class="px-6 py-4 text-center text-gray-300">

                                <template x-if="!editing">

                                    <div>

                                        @if($ip->deviceType)

                                            {{ $ip->deviceType->name }}

                                        @else

                                            <span class="text-gray-500 italic">
                                                Sin asignación
                                            </span>

                                        @endif

                                    </div>

                                </template>

                                <template x-if="editing">

                                    <div>

                                        <select
                                            name="device_type_id"
                                            form="form-{{ $ip->id }}"
                                            class="
                                                bg-[#1E293B]
                                                border border-gray-700
                                                rounded-lg
                                                px-3 py-2
                                                text-white
                                                text-sm
                                                w-52
                                            "
                                        >

                                            <option value="">
                                                Sin asignación
                                            </option>

                                            @foreach($deviceTypes as $deviceType)

                                                <option
                                                    value="{{ $deviceType->id }}"
                                                    {{ $ip->device_type_id == $deviceType->id ? 'selected' : '' }}
                                                >
                                                    {{ $deviceType->name }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </template>

                            </td>

                            {{-- Sucursal --}}
                            <td class="px-6 py-4 text-center text-gray-300">

                                @if($ip->branch)

                                    {{ $ip->branch->name }}

                                @else

                                    <span class="text-gray-500 italic">
                                        Sin asignación
                                    </span>

                                @endif

                            </td>

                            {{-- Departamento --}}
                            <td class="px-6 py-4 text-center text-gray-300">

                                <template x-if="!editing">

                                    <div>

                                        @if($ip->department)

                                            {{ $ip->department->name }}

                                        @else

                                            <span class="text-gray-500 italic">
                                                Sin asignación
                                            </span>

                                        @endif

                                    </div>

                                </template>

                                <template x-if="editing">

                                    <div>

                                        <select
                                            name="department_id"
                                            form="form-{{ $ip->id }}"
                                            class="
                                                bg-[#1E293B]
                                                border border-gray-700
                                                rounded-lg
                                                px-3 py-2
                                                text-white
                                                text-sm
                                                w-52
                                            "
                                        >

                                            <option value="">
                                                Sin asignación
                                            </option>

                                            @foreach($departments as $department)

                                                <option
                                                    value="{{ $department->id }}"
                                                    {{ $ip->department_id == $department->id ? 'selected' : '' }}
                                                >
                                                    {{ $department->name }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </template>

                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- Formulario --}}
                                    <form
                                        id="form-{{ $ip->id }}"
                                        method="POST"
                                        action="{{ route('ip-addresses.update', $ip) }}"
                                    >
                                        @csrf
                                        @method('PUT')
                                    </form>

                                    {{-- Editar --}}
                                    <button
                                        type="button"
                                        @click="editing = !editing"
                                        class="bg-yellow-500 hover:bg-yellow-600
                                               text-white p-2 rounded-lg transition"
                                    >
                                        ✏️
                                    </button>

                                    {{-- Guardar --}}
                                    <template x-if="editing">

                                        <div>

                                            <button
                                                type="submit"
                                                form="form-{{ $ip->id }}"
                                                class="bg-green-600 hover:bg-green-500
                                                       text-white p-2 rounded-lg transition"
                                            >
                                                💾
                                            </button>

                                        </div>

                                    </template>

                                    {{-- Ping --}}
                                    <button
                                        type="button"
                                        data-ip="{{ $ip->ip_address }}"
                                        class="
                                            ping-btn
                                            bg-blue-500 hover:bg-blue-600
                                            text-white p-2 rounded-lg transition
                                        "
                                    >
                                        📡
                                    </button>

                                    {{-- Liberar --}}
                                    <button
                                        type="button"
                                        data-id="{{ $ip->id }}"
                                        class="
                                            release-btn
                                            bg-green-600 hover:bg-green-500
                                            text-white p-2 rounded-lg transition
                                        "
                                    >
                                        🔓
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">

                                No hay IPs registradas.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Modal Ping --}}
    <div
        id="pingModal"
        class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center"
    >

        <div class="bg-[#0F172A] w-11/12 max-w-3xl rounded-2xl shadow-2xl overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">

                <h2
                    id="pingTitle"
                    class="text-white text-xl font-semibold"
                >
                    📡 Ping
                </h2>

                <button
                    id="closePingBtn"
                    class="text-gray-400 hover:text-white text-xl"
                >
                    ✖
                </button>

            </div>

            {{-- Consola --}}
            <div
                id="pingOutput"
                class="
                    bg-black
                    text-green-400
                    font-mono
                    text-sm
                    p-4
                    h-[400px]
                    overflow-y-auto
                "
            >
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-gray-800 flex justify-end">

                <button
                    id="stopPingBtn"
                    class="
                        bg-red-600 hover:bg-red-500
                        text-white
                        px-4 py-2
                        rounded-xl
                        transition
                    "
                >
                    Detener
                </button>

            </div>

        </div>

    </div>

    <script>

        // BUSCADOR GLOBAL
        const globalSearch =
            document.getElementById('globalSearch');

        const statusFilter =
            document.getElementById('statusFilter');

        function filterTable() {

            const searchValue =
                globalSearch.value.toLowerCase();

            const selectedStatus =
                statusFilter.value.toLowerCase();

            document.querySelectorAll('.ip-row').forEach(row => {

                const content =
                    row.dataset.search || '';

                const rowStatus =
                    row.dataset.status || '';

                const matchesSearch =
                    content.includes(searchValue);

                const matchesStatus =
                    !selectedStatus ||
                    rowStatus.includes(selectedStatus);

                row.style.display =
                    matchesSearch && matchesStatus
                        ? ''
                        : 'none';

            });

        }

        //modal de ping
        const stopPingBtn = document.getElementById('stopPingBtn');
        const closePingModal = document.getElementById('closePingBtn');

        globalSearch.addEventListener(
            'input',
            filterTable
        );

        statusFilter.addEventListener(
            'change',
            filterTable
        );

        function stopPing() {

            console.log('DETENIENDO');

            pingRunning = false;

            pingOutput.innerHTML +=
                '<div class="text-yellow-400">Ping detenido.</div>';

            pingModal.classList.add('hidden');

        }

        let pingRunning = false;

        function addPingLine(success, ip, message = '') {

            const line = document.createElement('div');

            const time = new Date().toLocaleTimeString(
                'es-CL',
                {
                    hour12: false
                }
            );

            line.textContent = success
                ? `[${time}] ✅ Respuesta desde ${ip}`
                : `[${time}] ❌ ${message}`;

            pingOutput.appendChild(line);

            pingOutput.scrollTop =
                pingOutput.scrollHeight;
        }

        function addErrorLine(message = 'Error ejecutando ping') {

            const line = document.createElement('div');

            const time = new Date().toLocaleTimeString(
                'es-CL',
                {
                    hour12: false
                }
            );

            line.textContent =
                `[${time}] ❌ ${message}`;

            pingOutput.appendChild(line);

            pingOutput.scrollTop =
                pingOutput.scrollHeight;
        }

        async function startPing(ip) {

            pingRunning = true;

            while (pingRunning) {

                try {

                    const response = await fetch(
                        "{{ route('ip-addresses.ping') }}",
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },

                            body: JSON.stringify({
                                ip
                            })
                        }
                    );

                    if (!response.ok) {

                        addErrorLine(
                            `Error HTTP ${response.status}`
                        );

                        await new Promise(
                            resolve => setTimeout(resolve, 2000)
                        );

                        continue;

                    }

                    const data = await response.json();

                    let message = 'Tiempo de espera agotado';

                    switch (data.state) {

                        case 'success':

                            addPingLine(
                                true,
                                ip
                            );

                            break;

                        case 'unreachable':

                            message =
                                'Host de destino inaccesible';

                            addPingLine(
                                false,
                                ip,
                                message
                            );

                            break;

                        case 'timeout':

                            message =
                                'Tiempo de espera agotado';

                            addPingLine(
                                false,
                                ip,
                                message
                            );

                            break;

                        case 'invalid':

                            message =
                                'IP inválida';

                            addPingLine(
                                false,
                                ip,
                                message
                            );

                            break;

                        default:

                            addPingLine(
                                false,
                                ip,
                                'Error desconocido'
                            );

                    }

                } catch (error) {

                    console.error(
                        'ERROR PING:',
                        error
                    );

                    addErrorLine();

                }

                await new Promise(
                    resolve => setTimeout(resolve, 2000)
                );

            }

        }

        document.querySelectorAll('.ping-btn').forEach(button => {

            button.addEventListener('click', () => {

                const ip = button.dataset.ip;

                if (!ip) return;

                pingModal.classList.remove('hidden');

                pingTitle.innerText =
                    `📡 Ping ${ip}`;

                pingOutput.innerHTML = '';

                pingRunning = false;

                setTimeout(() => {

                    startPing(ip);

                }, 100);

            });

        });

        closePingModal.addEventListener(
            'click',
            stopPing
        );

        stopPingBtn.addEventListener(
            'click',
            stopPing
        );

        // LIBERAR IP
        document.querySelectorAll('.release-btn').forEach(button => {

            button.addEventListener('click', async () => {

                if (!confirm('¿Liberar esta IP?')) {
                    return;
                }

                const id = button.dataset.id;

                try {

                    const response = await fetch(
                        `/ip-addresses/${id}/release`,
                        {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        }
                    );

                    const data = await response.json();

                    if (data.success) {

                        location.reload();

                    }

                } catch (error) {

                    alert('Error liberando IP');

                }

            });

        });

    </script>

</x-app-layout>
