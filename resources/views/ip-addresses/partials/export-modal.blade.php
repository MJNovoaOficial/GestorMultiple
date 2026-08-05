<div
    id="exportModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-6"
>

    <div class="w-full max-w-5xl max-h-[85vh] overflow-y-auto rounded-2xl bg-[#0F172A] shadow-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-800 px-6 py-5">

            <h2 class="text-2xl font-semibold text-white">
                📄 Exportar Direcciones IP
            </h2>

            <button
                id="closeExportModal"
                class="text-2xl text-gray-400 transition hover:text-white"
            >
                ✕
            </button>

        </div>

        {{-- Contenido --}}
        <div class="space-y-4 p-4">

            {{-- Formato --}}
            <div class="rounded-xl border border-gray-800 bg-[#020817] p-4">

                <h3 class="mb-4 text-lg font-semibold text-white">
                    Formato de exportación
                </h3>

                <div class="flex flex-wrap gap-4">

                    <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-emerald-600 bg-emerald-600/20 px-5 py-3 text-white">

                        <input
                            type="radio"
                            name="export_format"
                            value="excel"
                            checked
                        >

                        📗 Excel

                    </label>

                    <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-700 px-5 py-3 text-gray-300 hover:border-red-500">

                        <input
                            type="radio"
                            name="export_format"
                            value="pdf"
                        >

                        📕 PDF

                    </label>

                    <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-700 px-5 py-3 text-gray-300 hover:border-blue-500">

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

                <div class="mb-4">

                    <h3 class="mb-4 text-lg font-semibold text-white">
                        Ramas a exportar
                    </h3>

                    <div class="flex flex-wrap gap-2">

                        {{-- Todas --}}
                        <button
                            type="button"
                            id="selectAllSubnets"
                            class="
                                subnet-btn
                                px-4 py-2
                                rounded-xl
                                text-sm
                                font-medium
                                transition
                                bg-indigo-600
                                text-white
                                shadow-lg
                            "
                        >
                            Todas
                        </button>

                        {{-- Ramas --}}
                        @foreach($subnets as $subnet)

                            <button
                                type="button"
                                data-subnet="{{ $subnet }}"
                                class="
                                    subnet-btn
                                    px-4 py-2
                                    rounded-xl
                                    text-sm
                                    font-medium
                                    transition
                                    bg-[#1E293B]
                                    text-gray-300
                                    hover:bg-gray-700
                                "
                            >
                                {{ $subnet }}.x

                                <span class="ml-1 text-amber-400 font-semibold">
                                    (0)
                                </span>

                            </button>

                        @endforeach

                    </div>

                </div>

            </div>

            {{-- Columnas --}}
            <div class="rounded-xl border border-gray-800 bg-[#020817] p-4">

                <h3 class="mb-4 text-lg font-semibold text-white">
                    Columnas a exportar
                </h3>

                <div class="grid grid-cols-2 gap-3 md:grid-cols-3">

                    <label class="flex cursor-pointer items-center gap-3 rounded-xl bg-[#1E293B] px-4 py-3 hover:bg-[#334155]">
                        <input type="checkbox" checked>
                        <span class="text-white">IP</span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-3 rounded-xl bg-[#1E293B] px-4 py-3 hover:bg-[#334155]">
                        <input type="checkbox" checked>
                        <span class="text-white">Estado</span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-3 rounded-xl bg-[#1E293B] px-4 py-3 hover:bg-[#334155]">
                        <input type="checkbox" checked>
                        <span class="text-white">Usuario Responsable</span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-3 rounded-xl bg-[#1E293B] px-4 py-3 hover:bg-[#334155]">
                        <input type="checkbox" checked>
                        <span class="text-white">Dispositivo</span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-3 rounded-xl bg-[#1E293B] px-4 py-3 hover:bg-[#334155]">
                        <input type="checkbox" checked>
                        <span class="text-white">Sucursal</span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-3 rounded-xl bg-[#1E293B] px-4 py-3 hover:bg-[#334155]">
                        <input type="checkbox" checked>
                        <span class="text-white">Departamento</span>
                    </label>

                </div>

            </div>

            {{-- Filtros --}}
            <div class="rounded-xl border border-gray-800 bg-[#020817] p-4">

                <h3 class="mb-4 text-lg font-semibold text-white">
                    Estado
                </h3>

                <select
                    id="exportStatus"
                    class="w-72 rounded-xl border border-gray-700 bg-[#1E293B] px-4 py-3 text-white"
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

            {{-- Resumen --}}
            <div class="rounded-xl border border-indigo-700 bg-indigo-900/20 p-4">

                <h3 class="mb-4 text-lg font-semibold text-white">
                    Resumen de exportación
                </h3>

                <div class="grid grid-cols-2 gap-6 md:grid-cols-4">

                    <div>

                        <div class="text-sm text-gray-400">
                            Redes
                        </div>

                        <div
                            id="summaryNetworks"
                            class="text-2xl font-bold text-white"
                        >
                            {{ $subnets->count() }}
                        </div>

                    </div>

                    <div>

                        <div class="text-sm text-gray-400">
                            IPs ocupadas
                        </div>

                        <div
                            id="summaryIPs"
                            class="text-2xl font-bold text-amber-400"
                        >
                            0
                        </div>

                    </div>

                    <div>

                        <div class="text-sm text-gray-400">
                            Columnas
                        </div>

                        <div
                            id="summaryColumns"
                            class="text-2xl font-bold text-white"
                        >
                            6
                        </div>

                    </div>

                    <div>

                        <div class="text-sm text-gray-400">
                            Formato
                        </div>

                        <div
                            id="summaryFormat"
                            class="text-2xl font-bold text-emerald-400"
                        >
                            Excel
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Footer --}}
        <div class="flex justify-end gap-3 border-t border-gray-800 px-6 py-5">

            <button
                id="cancelExport"
                class="rounded-xl bg-gray-700 px-5 py-2 text-white transition hover:bg-gray-600"
            >
                Cancelar
            </button>

            <button
                id="startExport"
                class="rounded-xl bg-emerald-600 px-5 py-2 text-white transition hover:bg-emerald-700"
            >
                📄 Exportar
            </button>

        </div>

    </div>

</div>