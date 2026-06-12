<div class="grid grid-cols-1 md:grid-cols-3 gap-5">

    {{-- Nombre --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            Nombre <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="nombre"
            value="{{ old('nombre') }}"
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
            name="tipo"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
            <option value="">
                Seleccione un tipo
            </option>

            <option value="DVR" @selected(old('tipo') == 'DVR')>
                DVR
            </option>

            <option value="NVR" @selected(old('tipo') == 'NVR')>
                NVR
            </option>

            <option value="IPC" @selected(old('tipo') == 'IPC')>
                IPC
            </option>

        </select>
    </div>

    {{-- Modelo --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            Modelo <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="modelo"
            value="{{ old('modelo') }}"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
    </div>

    {{-- MP --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            MP <span class="text-red-500">*</span>
        </label>

        <select
            name="mp"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
            <option value="">
                Seleccione los MP
            </option>

            <option value="1MP" @selected(old('mp') == '1MP')>
                1MP
            </option>

            <option value="2MP" @selected(old('mp') == '2MP')>
                2MP
            </option>

            <option value="4MP" @selected(old('mp') == '4MP')>
                4MP
            </option>

            <option value="5MP" @selected(old('mp') == '5MP')>
                5MP
            </option>
            <option value="8MP" @selected(old('mp') == '8MP')>
                8MP
            </option>
        </select>
    </div>

    {{-- HDD --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            HDD <span class="text-red-500">*</span>
        </label>

        <select
            name="hdd"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
            <option value="">
                Seleccione Capacidad
            </option>

            <option value="128GB" @selected(old('hdd') == '128GB')>
                128 GB
            </option>

            <option value="256GB" @selected(old('hdd') == '256GB')>
                256 GB
            </option>

            <option value="1TB" @selected(old('hdd') == '1TB')>
                1 TB
            </option>

            <option value="2TB" @selected(old('hdd') == '2TB')>
                2 TB
            </option>
            <option value="4TB" @selected(old('hdd') == '4TB')>
                4 TB
            </option>
             <option value="6TB" @selected(old('hdd') == '6TB')>
                6 TB
            </option>
            <option value="8TB" @selected(old('hdd') == '8TB')>
                8 TB
            </option>
        </select>
    </div>

    {{-- SN --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            Número Serial <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="sn"
            value="{{ old('sn') }}"
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

    {{-- Contraseña --}}
    <div>
        <label class="block mb-2 text-sm font-medium text-white">
            Contraseña <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="password"
            value="{{ old('password') }}"
            class="w-full rounded-xl border border-slate-700 bg-slate-900 text-white px-4 py-3"
        >
    </div>
</div>
