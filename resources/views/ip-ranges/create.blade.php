<x-app-layout>

    <div class="p-6">

        <div class="max-w-3xl mx-auto bg-gray-900 rounded-2xl shadow-lg p-8 border border-slate-200 dark:border-slate-800">

            <h1 class="text-3xl font-bold text-white mb-2">
                Importar rango IP
            </h1>

            <p class="text-gray-400 mb-8">
                Genera múltiples direcciones IP automáticamente.
            </p>

            <form
                method="POST"
                action="{{ route('ip-ranges.store') }}"
            >
                @csrf

                {{-- IP inicial --}}
                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        IP inicial <span class="text-red-400">*</span>
                    </label>

                    <input
                        type="text"
                        name="start_ip"
                        placeholder="ej: 192.168.0.1"
                        class="w-full rounded-lg bg-gray-800 border text-white"
                        required
                        @error('start_ip')
                            border-red-500
                        @else
                            border-gray-700
                        @enderror
                    >
                        @error('start_ip')
                            <p class="mt-2 text-sm text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                </div>

                {{-- IP final --}}
                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        IP final <span class="text-red-400">*</span>
                    </label>

                    <input
                        type="text"
                        name="end_ip"
                        placeholder="ej: 192.168.3.255"
                        class="w-full rounded-lg bg-gray-800 border text-white"
                        required
                        @error('end_ip')
                            border-red-500
                        @else
                            border-gray-700
                        @enderror
                    >
                        @error('end_ip')
                            <p class="mt-2 text-sm text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                </div>

                {{-- Sucursal --}}
                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Sucursal <span class="text-red-400">*</span>
                    </label>

                    <select
                        name="branch_id"
                        class="w-full rounded-lg bg-gray-800 border text-white"
                        required
                    >

                        <option value="">
                            Seleccione sucursal
                        </option>

                        @foreach($branches as $branch)

                            <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Estado --}}
                <div class="mb-8">

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Estado inicial <span class="text-red-400">*</span>
                    </label>

                    <select
                        name="ip_status_id"
                        class="w-full rounded-lg bg-gray-800 border text-white"
                        required
                    >

                        <option value="">
                            Seleccione estado
                        </option>

                        @foreach($ipStatuses as $status)

                            <option value="{{ $status->id }}">
                                @switch($status->color)
                                    @case('green')
                                        🟢
                                        @break

                                    @case('blue')
                                        🔵
                                        @break

                                    @case('yellow')
                                        🟡
                                        @break

                                    @case('red')
                                        🔴
                                        @break

                                    @case('orange')
                                        🟠
                                        @break
                                @endswitch

                                {{ $status->name }}
                            </option>

                        @endforeach

                    </select>

                </div>
                <p class="text-xs text-gray-400">
                    <span class="text-red-400">*</span> Campos obligatorios
                </p>
                {{-- Botones --}}
                <div class="flex justify-end gap-3">

                    <a
                        href="{{ route('dashboard') }}"
                        class="px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-white"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="px-5 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white"
                    >
                        Importar rango
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>