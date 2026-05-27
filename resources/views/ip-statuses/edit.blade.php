<x-app-layout>

    <div class="p-6">

        <div class="max-w-2xl mx-auto bg-gray-900 rounded-xl shadow-lg p-6">

            <h1 class="text-2xl font-bold text-white mb-6">
                Editar estado IP
            </h1>

            <form
                method="POST"
                action="{{ route('ip-statuses.update', $ipStatus) }}"
            >
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Nombre estado <span class="text-red-400">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $ipStatus->name) }}"
                        class="w-full rounded-lg bg-gray-800 border text-white"
                        required
                        @error('name')
                            border-red-500
                        @else
                            border-gray-700
                        @enderror
                    >
                    @error('name')
                        <p class="text-red-400 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Color --}}
                <div class="mb-6">

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        ¿Cambiará de color? Seleccione el nuevo color o deje el mismo para no cambiarlo.
                    </label>

                    <select
                        name="color"
                        class="w-full rounded-lg bg-gray-800 border text-white"
                    >

                        <option value="green">
                            🟢 Verde
                        </option>

                        <option value="blue">
                            🔵 Azul
                        </option>

                        <option value="yellow">
                            🟡 Amarillo
                        </option>

                        <option value="red">
                            🔴 Rojo
                        </option>

                        <option value="orange">
                            🟠 Naranjo
                        </option>

                    </select>

                </div>

                <div class="flex justify-end gap-3">

                    <a
                        href="{{ route('ip-statuses.index') }}"
                        class="px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-white"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white"
                    >
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>