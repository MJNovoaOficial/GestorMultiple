<x-app-layout>
    <div class="p-6">
        <div class="max-w-2xl mx-auto bg-gray-900 rounded-xl shadow-lg p-6">

            <h1 class="text-2xl font-bold text-white mb-6">
                Nueva sucursal
            </h1>

            <form method="POST" action="{{ route('branches.store') }}">
                @csrf

                {{-- Nombre sucursal --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Nombre sucursal <span class="text-red-400">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Ej: CT Talca"
                        class="w-full rounded-lg bg-gray-800 border text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
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
                        Guardar sucursal
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>