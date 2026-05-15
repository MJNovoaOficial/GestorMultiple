<x-app-layout>

    <div class="p-6">

        {{-- Header --}}
        <div class="mb-6">

            <h1 class="text-3xl font-bold text-gray-900">
                Gestor de IPs
            </h1>

            <p class="text-gray-500 mt-1">
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

                        <tr
                            x-data="{ editing: false }"
                            class="border-b border-gray-800 hover:bg-[#0F172A] transition"
                        >

                            <form
                                method="POST"
                                action="{{ route('ip-addresses.update', $ip) }}"
                            >

                                @csrf
                                @method('PUT')

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

                                    {{-- Vista normal --}}
                                    <div x-show="!editing">

                                        @if ($ip->user_assigned)

                                            {{ $ip->user_assigned }}

                                        @else

                                            <span class="text-gray-500 italic">
                                                Sin asignación
                                            </span>

                                        @endif

                                    </div>

                                    {{-- Vista edición --}}
                                    <div x-show="editing">

                                        <input
                                            type="text"
                                            name="user_assigned"
                                            value="{{ $ip->user_assigned }}"
                                            placeholder="Usuario responsable"
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

                                </td>

                                {{-- Tipo de dispositivo --}}
                                <td class="px-6 py-4 text-center text-gray-300">

                                    {{-- Vista normal --}}
                                    <div x-show="!editing">

                                        @if($ip->deviceType)

                                            {{ $ip->deviceType->name }}

                                        @else

                                            <span class="text-gray-500 italic">
                                                Sin asignación
                                            </span>

                                        @endif

                                    </div>

                                    {{-- Vista edición --}}
                                    <div x-show="editing">

                                        <select
                                            name="device_type_id"
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

                                    {{-- Vista normal --}}
                                    <div x-show="!editing">

                                        @if($ip->department)

                                            {{ $ip->department->name }}

                                        @else

                                            <span class="text-gray-500 italic">
                                                Sin asignación
                                            </span>

                                        @endif

                                    </div>

                                    {{-- Vista edición --}}
                                    <div x-show="editing">

                                        <select
                                            name="department_id"
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

                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-center gap-2">

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
                                        <div x-show="editing">

                                            <button
                                                type="submit"
                                                class="bg-green-600 hover:bg-green-500
                                                       text-white p-2 rounded-lg transition"
                                            >
                                                💾
                                            </button>

                                        </div>

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

                            </form>

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

        {{-- Paginación --}}
        <div class="mt-6">
            {{ $ipAddresses->links() }}
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

        let pingInterval = null;

        const pingModal = document.getElementById('pingModal');
        const pingOutput = document.getElementById('pingOutput');
        const pingTitle = document.getElementById('pingTitle');

        function closePingModal() {

            clearInterval(pingInterval);

            pingOutput.innerHTML = '';

            pingModal.classList.add('hidden');

        }

        document.querySelectorAll('.ping-btn').forEach(button => {

            button.addEventListener('click', () => {

                const ip = button.dataset.ip;

                pingModal.classList.remove('hidden');

                pingTitle.innerText = `📡 Ping ${ip}`;

                pingOutput.innerHTML = '';

                clearInterval(pingInterval);

                pingInterval = setInterval(async () => {

                    try {

                        const response = await fetch(
                            "{{ route('ip-addresses.ping') }}",
                            {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ ip })
                            }
                        );

                        const data = await response.json();

                        const line = document.createElement('div');

                        const time = new Date().toLocaleTimeString();

                        line.innerHTML = data.success
                            ? `[${time}] ✅ Reply from ${ip}`
                            : `[${time}] ❌ Timeout`;

                        pingOutput.appendChild(line);

                        pingOutput.scrollTop = pingOutput.scrollHeight;

                    } catch (error) {

                        const line = document.createElement('div');

                        line.innerHTML = `❌ Error ejecutando ping`;

                        pingOutput.appendChild(line);

                    }

                }, 2000);

            });

        });

        document.getElementById('stopPingBtn')
            .addEventListener('click', closePingModal);

        document.getElementById('closePingBtn')
            .addEventListener('click', closePingModal);

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