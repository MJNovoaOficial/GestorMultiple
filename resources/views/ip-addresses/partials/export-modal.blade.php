{{-- export-modal.blade.php --}}
<div
    id="exportModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-6"
>

    <div class="w-full max-w-5xl max-h-[75vh] overflow-y-auto rounded-2xl bg-[#0F172A] shadow-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-800 px-5 py-4">

            <h2 class="text-xl font-semibold text-white">
                📄 Exportar Direcciones IP
            </h2>

            <button
                type="button"
                id="closeExportModal"
                class="text-xl text-gray-400 transition hover:text-white"
            >
                ✕
            </button>

        </div>

        <form
            id="exportForm"
            method="POST"
            action="{{ route('ip-addresses.export') }}"
        >

            @csrf

            {{-- Aquí JavaScript agregará las ramas seleccionadas --}}
            <div id="selectedSubnets"></div>

            <div class="space-y-4 p-4">

                {{-- Formato --}}
                <div class="rounded-xl border border-gray-800 bg-[#020817] p-4">

                    <h3 class="mb-3 text-base font-semibold text-white">
                        Formato de exportación
                    </h3>

                    <div class="flex flex-wrap gap-3">

                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-emerald-600 bg-emerald-600/20 px-4 py-2 text-white">

                            <input
                                type="radio"
                                name="export_format"
                                value="excel"
                                checked
                            >

                            📗 Excel

                        </label>

                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-700 px-4 py-2 text-gray-300 hover:border-red-500">

                            <input
                                type="radio"
                                name="export_format"
                                value="pdf"
                            >

                            📕 PDF

                        </label>

                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-700 px-4 py-2 text-gray-300 hover:border-blue-500">

                            <input
                                type="radio"
                                name="export_format"
                                value="print"
                            >

                            🖨 Imprimir

                        </label>

                    </div>

                </div>

                {{-- Ramas --}}
                <div class="rounded-xl border border-gray-800 bg-[#020817] p-4">

                    <h3 class="mb-3 text-base font-semibold text-white">
                        Ramas a exportar
                    </h3>

                    <div class="flex flex-wrap gap-2">

                        <button
                            type="button"
                            id="selectAllSubnets"
                            data-all="true"
                            data-selected="true"
                            class="subnet-btn rounded-xl bg-indigo-600 px-3 py-2 text-sm font-medium text-white shadow transition hover:bg-indigo-500"
                        >
                            Todas
                        </button>

                        @foreach($subnets as $subnet)

                            <button
                                type="button"
                                data-subnet="{{ $subnet }}"
                                data-selected="true"
                                class="subnet-btn rounded-xl bg-indigo-600 px-3 py-2 text-sm font-medium text-white shadow transition hover:bg-indigo-500"
                            >

                                {{ $subnet }}.x

                                <span class="ml-1 font-semibold text-amber-400">
                                    (0)
                                </span>

                            </button>

                        @endforeach

                    </div>

                </div>

                {{-- Panel inferior --}}
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

                    {{-- Columnas --}}
                    <div class="rounded-xl border border-gray-800 bg-[#020817] p-4 lg:col-span-2">

                        <h3 class="mb-3 text-base font-semibold text-white">
                            Columnas a exportar
                        </h3>

                        <div class="grid grid-cols-2 gap-3">

                            @foreach([
                                'ip' => 'IP',
                                'status' => 'Estado',
                                'user' => 'Usuario Responsable',
                                'device' => 'Dispositivo',
                                'branch' => 'Sucursal',
                                'department' => 'Departamento',
                            ] as $value => $label)

                                <label class="flex cursor-pointer items-center gap-3 rounded-xl bg-[#1E293B] px-4 py-2 transition hover:bg-[#334155]">

                                    <input
                                        type="checkbox"
                                        name="columns[]"
                                        value="{{ $value }}"
                                        checked
                                    >

                                    <span class="text-white">
                                        {{ $label }}
                                    </span>

                                </label>

                            @endforeach

                        </div>

                    </div>

                    {{-- Opciones --}}
                    <div class="rounded-xl border border-gray-800 bg-[#020817] p-4">

                        <h3 class="mb-3 text-base font-semibold text-white">
                            Opciones
                        </h3>

                        <label class="mb-2 block text-sm text-gray-300">
                            Estado
                        </label>

                        <select
                            id="exportStatus"
                            name="status"
                            class="w-full rounded-xl border border-gray-700 bg-[#1E293B] px-3 py-2 text-white"
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

                        <hr class="my-4 border-gray-700">

                        <h4 class="mb-3 font-semibold text-white">
                            Resumen
                        </h4>

                        <div class="space-y-2 text-sm">

                            <div class="flex justify-between">

                                <span class="text-gray-400">
                                    Redes
                                </span>

                                <span
                                    id="summaryNetworks"
                                    class="font-semibold text-white"
                                >
                                    {{ $subnets->count() }}
                                </span>

                            </div>

                            <div class="flex justify-between">

                                <span class="text-gray-400">
                                    IPs ocupadas
                                </span>

                                <span
                                    id="summaryIPs"
                                    class="font-semibold text-amber-400"
                                >
                                    0
                                </span>

                            </div>

                            <div class="flex justify-between">

                                <span class="text-gray-400">
                                    Columnas
                                </span>

                                <span
                                    id="summaryColumns"
                                    class="font-semibold text-white"
                                >
                                    6
                                </span>

                            </div>

                            <div class="flex justify-between">

                                <span class="text-gray-400">
                                    Formato
                                </span>

                                <span
                                    id="summaryFormat"
                                    class="font-semibold text-emerald-400"
                                >
                                    Excel
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 border-t border-gray-800 px-5 py-4">

                <button
                    type="button"
                    id="cancelExport"
                    class="rounded-xl bg-gray-700 px-5 py-2 text-white transition hover:bg-gray-600"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    id="startExport"
                    class="rounded-xl bg-emerald-600 px-5 py-2 text-white transition hover:bg-emerald-700"
                >
                    📄 Exportar
                </button>

            </div>

        </form>

    </div>

</div>