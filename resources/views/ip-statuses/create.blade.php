<x-app-layout>

    <div class="p-6">

        <div class="max-w-2xl mx-auto bg-gray-900 rounded-xl shadow-lg p-6">

            <h1 class="text-2xl font-bold text-white mb-6">
                Nuevo estado IP
            </h1>

            <form
                method="POST"
                action="{{ route('ip-statuses.store') }}"
            >
                @csrf

                {{-- Nombre --}}
                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Nombre estado
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Ej: Libre"
                        class="w-full rounded-lg bg-gray-800 border border-gray-700 text-white"
                        required
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
                        Clase color Tailwind
                    </label>

                    <input
                        type="text"
                        name="color"
                        value="{{ old('color') }}"
                        placeholder="Ej: bg-green-500"
                        class="w-full rounded-lg bg-gray-800 border border-gray-700 text-white"
                        required
                    >

                    @error('color')
                        <p class="text-red-400 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

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
                        Guardar estado
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>