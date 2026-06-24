<div class="grid grid-cols-1 md:grid-cols-3 gap-5">

    {{-- Número --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            Número <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="number"
            value="{{ old('number') }}"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
    </div>

    {{-- Serial --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            Serial <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="serial"
            value="{{ old('serial') }}"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
    </div>

    {{-- MAC --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            MAC <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="mac"
            value="{{ old('mac') }}"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
    </div>

    {{-- IP --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            IP <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="ip"
            value="{{ old('ip') }}"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
    </div>

    {{-- Área --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            Área <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="area"
            value="{{ old('area') }}"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
    </div>

    {{-- Sucursal --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            Sucursal <span class="text-red-500">*</span>
        </label>

        <select
            name="branch_id"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
            <option value="">
                Seleccione una sucursal
            </option>

            @foreach($branches as $branch)

                <option
                    value="{{ $branch->id }}"
                    @selected(old('branch_id') == $branch->id)
                >
                    {{ $branch->name }}
                </option>

            @endforeach

        </select>
    </div>

    {{-- Tipo --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            Tipo <span class="text-red-500">*</span>
        </label>

        <select
            name="type"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
            <option value="">
                Seleccione un tipo
            </option>

            <option value="windows" @selected(old('type') == 'windows')>
                Windows
            </option>

            <option value="android" @selected(old('type') == 'android')>
                Android
            </option>

            <option value="cellphone" @selected(old('type') == 'cellphone')>
                Celular
            </option>

        </select>
    </div>

    {{-- Estado --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            Estado <span class="text-red-500">*</span>
        </label>

        <select
            name="status"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
            <option value="operative">
                Operativa
            </option>

            <option value="repair">
                Reparación
            </option>

            <option value="retired">
                Dado de baja
            </option>

        </select>

    </div>

    <div>
        <div class="flex items-center gap-8 mt-8">
            <label class="inline-flex items-center cursor-pointer">

                <input type="hidden" name="blocked" value="0">

                <input
                    type="checkbox"
                    name="blocked"
                    value="1"
                    class="sr-only peer"
                >

                <div class="
                    relative
                    w-11 h-6
                    bg-slate-700
                    rounded-full
                    transition-colors

                    peer-checked:bg-blue-600

                    after:content-['']
                    after:absolute
                    after:top-[2px]
                    after:left-[2px]
                    after:bg-white
                    after:rounded-full
                    after:h-5
                    after:w-5
                    after:transition-all

                    peer-checked:after:translate-x-full
                "></div>

                <span class="ml-3 text-white">
                    Bloqueada
                </span>

            </label>

            <label class="inline-flex items-center cursor-pointer">

                <input type="hidden" name="warranty" value="0">

                <input
                    type="checkbox"
                    name="warranty"
                    value="1"
                    class="sr-only peer"
                >

                <div class="
                    relative
                    w-11 h-6
                    bg-slate-700
                    rounded-full
                    transition-colors

                    peer-checked:bg-blue-600

                    after:content-['']
                    after:absolute
                    after:top-[2px]
                    after:left-[2px]
                    after:bg-white
                    after:rounded-full
                    after:h-5
                    after:w-5
                    after:transition-all

                    peer-checked:after:translate-x-full
                "></div>

                <span class="ml-3 text-white">
                    Posee garantía
                </span>

            </label>
        </div>
    </div>
</div>

{{-- Observaciones --}}
<div class="mt-6">

    <label class="block mb-2 text-sm font-medium text-white">
        Observaciones
    </label>

    <textarea
        name="observations"
        rows="4"
        class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
    >{{ old('observations') }}</textarea>

</div>