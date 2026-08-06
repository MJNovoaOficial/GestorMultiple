{{-- export-modal.blade.php --}}
<style>
    #exportModal .export-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(15rem, 1fr);
        gap: 0.75rem;
    }

    #exportModal .export-columns-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        column-gap: 1rem;
        row-gap: 0.5rem;
    }

    @media (max-width: 640px) {
        #exportModal .export-main-grid,
        #exportModal .export-columns-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div
    id="exportModal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 p-4 sm:p-6"
>
    <div class="max-h-[90vh] w-full max-w-5xl overflow-y-auto rounded-2xl bg-[#0F172A] shadow-2xl">
        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-800 px-5 py-3">
            <div>
                <h2 class="text-lg font-semibold text-white">
                    📄 Exportar Direcciones IP
                </h2>
                <p class="mt-0.5 text-xs text-gray-400">
                    Configura el contenido y formato de tu exportación.
                </p>
            </div>

            <button
                type="button"
                id="closeExportModal"
                aria-label="Cerrar modal de exportación"
                class="rounded-lg p-2 text-xl leading-none text-gray-400 transition hover:bg-gray-800 hover:text-white"
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

            {{-- JavaScript agrega aquí los inputs subnets[] seleccionados. --}}
            <div id="selectedSubnets"></div>

            <div class="space-y-3 p-4 sm:p-5">
                {{-- Formato --}}
                <section class="rounded-xl border border-gray-800 bg-[#020817] px-4 py-3">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <h3 class="text-sm font-semibold text-white">
                            Formato de exportación
                        </h3>

                        <div class="flex flex-wrap gap-2">
                            <label class="flex cursor-pointer items-center gap-2 rounded-lg border border-emerald-600 bg-emerald-600/20 px-3 py-1.5 text-sm text-white transition hover:bg-emerald-600/30">
                                <input
                                    type="radio"
                                    name="export_format"
                                    value="excel"
                                    checked
                                >
                                📗 Excel
                            </label>

                            <label class="flex cursor-pointer items-center gap-2 rounded-lg border border-gray-700 px-3 py-1.5 text-sm text-gray-300 transition hover:border-red-500 hover:text-white">
                                <input
                                    type="radio"
                                    name="export_format"
                                    value="pdf"
                                >
                                📕 PDF
                            </label>

                            <label class="flex cursor-pointer items-center gap-2 rounded-lg border border-gray-700 px-3 py-1.5 text-sm text-gray-300 transition hover:border-blue-500 hover:text-white">
                                <input
                                    type="radio"
                                    name="export_format"
                                    value="print"
                                >
                                🖨 Imprimir
                            </label>
                        </div>
                    </div>
                </section>

                {{-- Ramas, opciones y resumen --}}
                <div class="export-main-grid">
                    <section class="rounded-xl border border-gray-800 bg-[#020817] p-4">
                        <div class="mb-3 flex items-center justify-between gap-3">
                            <h3 class="text-sm font-semibold text-white">
                                Ramas a exportar
                            </h3>

                            <button
                                type="button"
                                id="selectAllSubnets"
                                data-all="true"
                                data-selected="true"
                                class="subnet-btn rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white shadow transition hover:bg-indigo-500"
                            >
                                Todas
                            </button>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @foreach($subnets as $subnet)
                                <button
                                    type="button"
                                    data-subnet="{{ $subnet }}"
                                    data-count="{{ $subnetCounts[$subnet] ?? 0 }}"
                                    data-selected="true"
                                    class="subnet-btn rounded-lg bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white shadow transition hover:bg-indigo-500"
                                >
                                    {{ $subnet }}.x
                                    <span class="ml-1 font-semibold text-amber-400">
                                        ({{ $subnetCounts[$subnet] ?? 0 }})
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    </section>

                    <aside class="rounded-xl border border-gray-800 bg-[#020817] p-4">
                        <h3 class="mb-2 text-sm font-semibold text-white">
                            Opciones
                        </h3>

                        <label for="exportStatus" class="mb-1 block text-xs text-gray-400">
                            Estado
                        </label>
                        <select
                            id="exportStatus"
                            name="status"
                            class="w-full rounded-lg border border-gray-700 bg-[#1E293B] px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                        >
                            <option value="">Todos los estados</option>

                            @foreach($ipStatuses as $status)
                                <option value="{{ strtolower($status->name) }}">
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>

                        <div class="my-3 border-t border-gray-800"></div>

                        <h4 class="mb-2 text-sm font-semibold text-white">
                            Resumen
                        </h4>

                        <dl class="space-y-1.5 text-sm">
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-gray-400">Redes</dt>
                                <dd id="summaryNetworks" class="font-semibold text-white">
                                    {{ $subnets->count() }}
                                </dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-gray-400">IPs ocupadas</dt>
                                <dd id="summaryNetworks">
                                    {{ $subnets->count() }}
                                </dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-gray-400">Columnas</dt>
                                <dd id="summaryColumns" class="font-semibold text-white">6</dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-gray-400">Formato</dt>
                                <dd id="summaryFormat" class="font-semibold text-emerald-400">Excel</dd>
                            </div>
                        </dl>
                    </aside>
                </div>

                {{-- Columnas --}}
                <section class="rounded-xl border border-gray-800 bg-[#020817] p-4">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <h3 class="text-sm font-semibold text-white">
                            Columnas a exportar
                        </h3>
                        <span class="text-xs text-gray-500">Selecciona los campos incluidos</span>
                    </div>

                    <div class="export-columns-grid">
                        @foreach([
                            'ip' => 'IP',
                            'status' => 'Estado',
                            'user' => 'Usuario Responsable',
                            'device' => 'Dispositivo',
                            'branch' => 'Sucursal',
                            'department' => 'Departamento',
                        ] as $value => $label)
                            <label class="flex cursor-pointer items-center gap-2 rounded-lg px-2 py-1.5 text-sm text-gray-300 transition hover:bg-[#1E293B] hover:text-white">
                                <input
                                    type="checkbox"
                                    class="column-checkbox rounded border-gray-600 bg-[#1E293B] text-indigo-600 focus:ring-indigo-500"
                                    name="columns[]"
                                    value="{{ $value }}"
                                    checked
                                >
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </section>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 border-t border-gray-800 px-5 py-3">
                <button
                    type="button"
                    id="cancelExport"
                    class="rounded-lg bg-gray-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-600"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    id="startExport"
                    class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-700"
                >
                    📄 Exportar
                </button>
            </div>
        </form>
    </div>
</div>
