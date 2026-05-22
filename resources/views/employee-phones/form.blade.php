@csrf

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

    {{-- NÚMERO --}}

    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            Número <span class="text-red-400">*</span>
        </label>

        <div class="
            flex
            items-center

            overflow-hidden

            rounded-xl

            border
            border-slate-700

            bg-slate-900
        ">

            {{-- PREFIJO CHILE --}}

            <div class="
                flex
                items-center
                gap-2

                border-r
                border-slate-700

                px-4 py-3

                bg-slate-800

                text-white
                font-medium
            ">

                🇨🇱

                <span class="text-slate-300">
                    +56
                </span>

            </div>

            {{-- INPUT --}}

            <input
                type="text"

                id="phone_number"

                name="phone_number"

                maxlength="9"

                inputmode="numeric"

                placeholder="912345678"

                value="{{ old('phone_number', $device->phone_number ?? '') }}"

                class="
                    w-full

                    @error('phone_number')
                        border-red-500
                    @else
                        border-0
                    @enderror

                    bg-slate-900

                    px-4 py-3

                    text-white

                    focus:ring-0
                    focus:outline-none
                "
            >
            

        </div>
            @error('phone_number')

                <p class="
                    mt-2
                    text-sm
                    text-red-400
                ">
                    {{ $message }}
                </p>

            @enderror
        <p
            id="phone-error"

            class="
                mt-2
                text-sm
                text-red-400
                hidden
            "
        >
            El número debe contener 9 dígitos.
        </p>
    </div>

    {{-- NOMBRE --}}

    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            Nombre <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="first_name"

            value="{{ old('first_name', $device->first_name ?? '') }}"

            class="
                w-full

                rounded-xl

                @error('first_name')
                    border-red-500
                @else
                    border-slate-700
                @enderror

                bg-slate-900

                px-4 py-3

                text-white
            "
        >

        @error('first_name')

            <p class="
                mt-2
                text-sm
                text-red-400
            ">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- APELLIDO --}}

    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            Apellido <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="last_name"

            value="{{ old('last_name', $device->last_name ?? '') }}"

            class="
                w-full

                rounded-xl

                @error('last_name')
                    border-red-500
                @else
                    border-slate-700
                @enderror

                bg-slate-900

                px-4 py-3

                text-white
            "
        >

        @error('last_name')

            <p class="
                mt-2
                text-sm
                text-red-400
            ">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- MODELO --}}

    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            Modelo <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="phone_model"

            value="{{ old('phone_model', $device->phone_model ?? '') }}"

            class="
                w-full

                rounded-xl

                @error('phone_model')
                    border-red-500
                @else
                    border-slate-700
                @enderror

                bg-slate-900

                px-4 py-3

                text-white
            "
        >

        @error('phone_model')

            <p class="
                mt-2
                text-sm
                text-red-400
            ">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- FECHA DE ENTREGA --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            Fecha Entrega <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            id="delivery_date"
            name="delivery_date"
            placeholder="Seleccione fecha"
            readonly

            value="{{ old('delivery_date', isset($device?->delivery_date) ? $device->delivery_date->format('Y-m-d') : '') }}"

            class="
                w-full

                rounded-xl

                border
                border-slate-700

                bg-slate-900

                px-4 py-3

                text-white
            "
        >
        @error('phone_number')

            <p class="
                mt-2
                text-sm
                text-red-400
            ">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- IMEI --}}

    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            IMEI <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="imei"

            value="{{ old('imei', $device->imei ?? '') }}"

            class="
                w-full

                rounded-xl

                @error('imei')
                    border-red-500
                @else
                    border-slate-700
                @enderror

                bg-slate-900

                px-4 py-3

                text-white
            "
        >
        @error('first_name')

            <p class="
                mt-2
                text-sm
                text-red-400
            ">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- CARGO --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            Cargo <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="position"

            value="{{ old('position', $device->position ?? '') }}"

            class="
                w-full
                rounded-xl
                @error('position')
                    border-red-500
                @else
                    border-slate-700
                @enderror
                bg-slate-900
                px-4 py-3
                text-white
            "
        >

        @error('position')

            <p class="
                mt-2
                text-sm
                text-red-400
            ">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- ÁREA --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            Área <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="department"

            value="{{ old('department', $device->department ?? '') }}"

            class="
                w-full
                rounded-xl

                @error('department')
                    border-red-500
                @else
                    border-slate-700
                @enderror
                bg-slate-900
                px-4 py-3
                text-white
            "
        >
        @error('department')

            <p class="
                mt-2
                text-sm
                text-red-400
            ">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- CÓDIGO VENDEDOR --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            Código Vendedor <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="vendor_code"

            value="{{ old('vendor_code', $device->vendor_code ?? '') }}"

            class="
                w-full
                rounded-xl
                @error('vendor_code')
                    border-red-500
                @else
                    border-slate-700
                @enderror
                bg-slate-900
                px-4 py-3
                text-white
            "
        >

    </div>

    {{-- EMPRESA --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            Empresa <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="company_name"

            value="{{ old('company_name', $device->company_name ?? '') }}"

            class="
                w-full
                rounded-xl
                @error('company_name')
                    border-red-500
                @else
                    border-slate-700
                @enderror
                bg-slate-900
                px-4 py-3
                text-white
            "
        >

    </div>
    
    {{-- RUT --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            RUT <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="rut"
            id="rut"

            value="{{ old('rut', $device->rut ?? '') }}"

            class="
                w-full
                rounded-xl
                @error('rut')
                    border-red-500
                @else
                    border-slate-700
                @enderror
                bg-slate-900
                px-4 py-3
                text-white
            "
        >

    </div>

    {{-- CORREO --}}

    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            Correo <span class="text-red-400">*</span>
        </label>

        <input
            type="email"
            name="email"

            value="{{ old('email', $device->email ?? '') }}"

            class="
                w-full

                rounded-xl

                @error('email')
                    border-red-500
                @else
                    border-slate-700
                @enderror

                bg-slate-900

                px-4 py-3

                text-white
            "
        >

    </div>

    {{-- OBSERVACIONES --}}
    <div class="md:col-span-2 xl:col-span-3">

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-slate-300
        ">
            Observaciones
        </label>

        <textarea
            name="observations"
            rows="4"

            class="
                w-full

                rounded-xl

                border
                border-slate-700

                bg-slate-900

                px-4 py-3

                text-white
            "
        >{{ old('observations', $device->observations ?? '') }}</textarea>

    </div>
</div>