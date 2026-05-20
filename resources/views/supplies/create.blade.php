<x-app-layout>

    <div class="max-w-2xl mx-auto space-y-6">

        {{-- Header --}}
        <div>

            <h1 class="
                text-3xl font-bold
                text-slate-900 dark:text-white
            ">
                Registrar suministro
            </h1>

            <p class="
                mt-2
                text-slate-600 dark:text-slate-400
            ">
                Agrega un nuevo suministro al inventario.
            </p>

        </div>

        {{-- Card --}}
        <div class="p-6 bg-gray-900 border border-gray-800 rounded-2xl">

            <form
                action="{{ route('supplies.store') }}"
                method="POST"
                class="space-y-6"
            >

                @csrf

                {{-- Grid --}}
                <div class="gap-6 space-y-5">

                    {{-- Marca --}}
                    <div>

                        <label class="
                            block mb-2 
                            text-sm font-semibold
                            text-gray-300
                        ">
                            Marca de Impresora
                        </label>

                        <input
                            type="text"
                            name="brand"
                            value="{{ old('brand') }}"
                            class="
                                w-full rounded-lg bg-gray-800 border border-gray-700 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500
                            "
                            required
                        >

                    </div>

                    {{-- Modelo --}}
                    <div>

                        <label class="
                            block mb-2
                            text-sm font-semibold
                            text-slate-300
                        ">
                            Modelo impresora
                        </label>

                        <input
                            type="text"
                            name="printer_model"
                            value="{{ old('printer_model') }}"
                            class="
                                w-full rounded-lg bg-gray-800 border border-gray-700 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500
                            "
                            required
                        >

                    </div>

                    {{-- Tipo --}}
                    <div>

                        <label class="
                            block mb-2
                            text-sm font-semibold
                            text-slate-300 
                        ">
                            Modelo suministro
                        </label>

                        <input
                            type="text"
                            name="supply_type"
                            value="{{ old('supply_type') }}"
                            class="
                                w-full rounded-lg bg-gray-800 border border-gray-700 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500
                            "
                            required
                        >

                    </div>

                    {{-- Cantidad --}}
                    <div>

                        <label class="
                            block mb-2
                            text-sm font-semibold
                            text-gray-300 
                        ">
                            Cantidad
                        </label>

                        <input
                            type="number"
                            name="quantity"
                            min="0"
                            value="{{ old('quantity', 0) }}"
                            class="
                                w-full rounded-lg bg-gray-800 border border-gray-700 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500
                            "
                            required
                        >

                    </div>

                    {{-- Stock mínimo --}}
                    <div>

                        <label class="
                            block mb-2
                            text-sm font-semibold
                            text-gray-300 
                        ">
                            Stock mínimo
                        </label>

                        <input
                            type="number"
                            name="minimum_stock"
                            min="0"
                            value="{{ old('minimum_stock', 1) }}"
                            class="
                                w-full rounded-lg bg-gray-800 border border-gray-700 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500  
                            "
                            required
                        >

                    </div>

                </div>

                {{-- Actions --}}
                <div class="
                    flex items-center justify-end
                    gap-3
                ">

                    <a
                        href="{{ route('supplies.index') }}"
                        class="
                            px-5 py-3
                            rounded-xl
                            border border-slate-600                      
                            transition
                            text-slate-300                            
                            hover:bg-slate-800
                        "
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="
                            px-5 py-3
                            rounded-xl
                            bg-blue-600 hover:bg-blue-700
                            text-white font-semibold
                            transition
                        "
                    >
                        Guardar suministro
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>