<div id="exportModal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full">

    <div class="relative p-4 w-full max-w-lg">

        <div class="bg-white rounded-lg shadow dark:bg-gray-800">

            <div class="p-6">

                <h3 class="text-lg font-semibold mb-4">
                    Exportar DVRs
                </h3>

                <form action="{{ route('dvrs.export') }}" method="GET">

                    @php
                        $columns = [
                            'nombre' => 'Nombre',
                            'branch_id' => 'Sucursal',
                            'tipo' => 'Tipo',
                            'modelo' => 'Modelo',
                            'mp' => 'MP',
                            'hdd' => 'HDD',
                            'sn' => 'SN',
                            'ip' => 'IP',
                            'password' => 'Contraseña',
                        ];
                    @endphp

                    <div class="grid grid-cols-2 gap-3">

                        @foreach($columns as $value => $label)

                            <label class="flex items-center gap-2">

                                <input
                                    type="checkbox"
                                    name="columns[]"
                                    value="{{ $value }}"
                                    checked>

                                {{ $label }}

                            </label>

                        @endforeach

                    </div>

                    <div class="mt-6 flex justify-end gap-2">

                        <button
                            type="button"
                            id="close-export-modal"
                            data-modal-hide="exportModal"
                            class="px-4 py-2 rounded bg-gray-500 text-white">

                            Cancelar

                        </button>

                        <button
                            class="px-4 py-2 rounded bg-green-600 text-white">

                            Exportar

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>