<x-app-layout>
    <div class="p-6">
        <div class="max-w-2xl mx-auto bg-gray-900 rounded-xl shadow-lg p-6">

            <h1 class="text-2xl font-bold text-white mb-6">
                Editar sucursal
            </h1>

            <form
                method="POST"
                action="{{ route('branches.update', $branch) }}"
            >
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Nombre sucursal
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $branch->name) }}"
                        class="w-full rounded-lg bg-gray-800 border border-gray-700 text-white"
                        required
                    >

                    @error('name')
                        <p class="text-red-400 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Ciudad --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Ciudad
                    </label>

                    <input
                        type="text"
                        name="city"
                        value="{{ old('city', $branch->city) }}"
                        class="w-full rounded-lg bg-gray-800 border border-gray-700 text-white"
                    >

                    @error('city')
                        <p class="text-red-400 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-3">

                    <a
                        href="{{ route('branches.index') }}"
                        class="px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-white"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium"
                    >
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>
    </div>
</x-app-layout>