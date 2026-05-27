<x-app-layout>

    <div class="p-6">

        <div class="max-w-2xl mx-auto bg-gray-900 rounded-xl shadow-lg p-6">

            <h1 class="text-2xl font-bold text-white mb-6">
                Nuevo tipo de dispositivo
            </h1>

            <form
                method="POST"
                action="{{ route('device-types.store') }}"
            >
                @csrf

                <div class="mb-6">

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Nombre del tipo de dispositivo <span class="text-red-400">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Ej: Notebook"
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

                <div class="flex justify-end gap-3">

                    <a
                        href="{{ route('device-types.index') }}"
                        class="px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-white"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white"
                    >
                        Guardar tipo de dispositivo
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>