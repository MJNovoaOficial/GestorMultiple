@csrf
<div class="
    grid
    grid-cols-1
    md:grid-cols-2
    xl:grid-cols-3
    gap-6
">

    {{-- Nombre Usuario --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            text-gray-300
        ">
            Nombre Usuario
            <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="user_name"

            value="{{ old('user_name', $notebook->user_name ?? '') }}"

            class="
                w-full
                rounded-xl
                border

                @error('user_name')
                    border-red-500
                @else
                    border-slate-700
                @enderror

                bg-slate-900

                px-4 py-3

                text-white
            "
        >

        @error('user_name')

            <p class="
                mt-2
                text-sm
                text-red-400
            ">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- RUT --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            font-medium
            text-gray-300
        ">
            RUT <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="user_rut"
            id="user_rut"

            value="{{ old('user_rut', $notebook->user_rut ?? '') }}"

            class="
                w-full
                rounded-xl
                border

                @error('user_rut')
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

    {{-- Serial --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            text-gray-300
        ">
            Número Serial
            <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="serial_number"

            value="{{ old('serial_number', $notebook->serial_number ?? '') }}"

            class="
                w-full
                rounded-xl
                border

                @error('serial_number')
                    border-red-500
                @else
                    border-slate-700
                @enderror

                bg-slate-900

                px-4 py-3

                text-white
            "
        >

        @error('serial_number')

            <p class="
                mt-2
                text-sm
                text-red-400
            ">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- Marca --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            text-gray-300
        ">
            Marca
            <span class="text-red-400">*</span>
        </label>

        <select
            name="brand_id"

            class="
                w-full
                rounded-xl
                border

                @error('brand_id')
                    border-red-500
                @else
                    border-slate-700
                @enderror

                bg-slate-900

                px-4 py-3

                text-white
            "
        >

            <option value="">
                Seleccione una marca
            </option>

            @foreach($brands as $brand)

                <option
                    value="{{ $brand->id }}"

                    @selected(
                        old(
                            'brand_id',
                            $notebook->brand_id ?? ''
                        ) == $brand->id
                    )
                >
                    {{ $brand->name }}
                </option>

            @endforeach

        </select>

        @error('brand_id')

            <p class="
                mt-2
                text-sm
                text-red-400
            ">
                {{ $message }}
            </p>

        @enderror

    </div>

    {{-- Modelo --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            text-gray-300
        ">
            Modelo
            <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="model"

            value="{{ old('model', $notebook->model ?? '') }}"

            class="
                w-full
                rounded-xl
                border

                @error('model')
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

    {{-- Fecha Entrega --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            text-gray-300
        ">
            Fecha Entrega
            <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            id="delivery_date"
            name="delivery_date"
            placeholder="Seleccione fecha"
            readonly

            value="{{ old('delivery_date', isset($notebook?->delivery_date) ? $notebook->delivery_date->format('Y-m-d') : '') }}"

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
        @error('delivery_date')
            <p class="
                mt-2 
                text-sm 
                text-red-400
            ">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Valor --}}
    <div>

        <label class="block mb-2 text-sm text-gray-300">
            Valor Equipo
            <span class="text-red-400">*</span>
        </label>

        <div class="flex">

            <span class="
                inline-flex
                items-center
                px-4
                rounded-l-xl
                border
                border-slate-700
                bg-slate-800
                text-white
            ">
                $
            </span>

            <input
                type="number"
                id="purchase_value"
                name="purchase_value"

                value="{{ old('purchase_value') }}"

                class="
                    flex-1
                    rounded-r-xl
                    border
                    border-slate-700
                    bg-slate-900
                    px-4
                    py-3
                    text-white
                "
            >

        </div>

    </div>

    {{-- Condición --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            text-gray-300
        ">
            Condición
            <span class="text-red-400">*</span>
        </label>

        <select
            name="condition"

            class="
                w-full
                rounded-xl
                border

                @error('condition')
                    border-red-500
                @else
                    border-slate-700
                @enderror

                bg-slate-900

                px-4 py-3

                text-white
            "
        >

            <option value="">
                Seleccione condición
            </option>

            <option
                value="new"

                @selected(
                    old(
                        'condition',
                        $notebook->condition ?? ''
                    ) == 'new'
                )
            >
                Nuevo
            </option>

            <option
                value="refurbished"

                @selected(
                    old(
                        'condition',
                        $notebook->condition ?? ''
                    ) == 'refurbished'
                )
            >
                Reacondicionado
            </option>

        </select>

    </div>

    {{-- Estado --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            text-gray-300
        ">
            Estado
            <span class="text-red-400">*</span>
        </label>

        <select
            name="status"

            class="
                w-full
                rounded-xl
                border

                @error('status')
                    border-red-500
                @else
                    border-slate-700
                @enderror

                bg-slate-900

                px-4 py-3

                text-white
            "
        >

            <option value="">
                Seleccione estado
            </option>

            <option
                value="available"

                @selected(
                    old(
                        'status',
                        $notebook->status ?? ''
                    ) == 'available'
                )
            >
                Disponible
            </option>

            <option
                value="assigned"

                @selected(
                    old(
                        'status',
                        $notebook->status ?? ''
                    ) == 'assigned'
                )
            >
                Ocupado
            </option>

            <option
                value="retired"

                @selected(
                    old(
                        'status',
                        $notebook->status ?? ''
                    ) == 'retired'
                )
            >
                Dado de baja
            </option>

        </select>

    </div>

    {{-- Cargo --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            text-gray-300
        ">
            Cargo
            <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="position"

            value="{{ old('position', $notebook->position ?? '') }}"

            class="
                w-full
                rounded-xl
                border

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

    </div>

    {{-- Empresa --}}
    <div>

        <label class="
            block
            mb-2
            text-sm
            text-gray-300
        ">
            Empresa
            <span class="text-red-400">*</span>
        </label>

        <input
            type="text"
            name="company_name"

            value="{{ old('company_name', $notebook->company_name ?? '') }}"

            class="
                w-full
                rounded-xl
                border

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

</div>

{{-- OBSERVACIONES --}}
<div class="mt-6">

    <label class="
        block
        mb-2
        text-sm
        text-gray-300
    ">
        Observaciones
    </label>

    <textarea
        name="observations"

        class="
            w-full

            min-h-[120px]

            rounded-xl

            border

            @error('observations')
                border-red-500
            @else
                border-slate-700
            @enderror

            bg-slate-900

            px-4 py-3

            text-white
        "
    >{{ old('observations', $notebook->observations ?? '') }}</textarea>

    <p class="text-xs text-gray-400">
        <span class="text-red-400">*</span> Campos obligatorios
    </p>
    {{-- Info --}}
    <div
        class="
            flex items-start gap-3
            p-4 rounded-2xl
            border border-yellow-300
            mb-10
            "
            style="
                background-color: #FFF2CC;
                "
            >

            {{-- Icono --}}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 mt-0.5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    style="color: #B45309;"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v2m0 4h.01M10.29 3.86l-7.5 13
                        A1 1 0 003.66 18h16.68a1 1 0 00.87-1.5l-7.5-13
                        a1 1 0 00-1.74 0z"
                    />
                        </svg>
                        {{-- Texto --}}
                        <p
                            class="text-sm leading-relaxed"
                            style="color: #78350F;"
                        >

                            Si tu dispositivo no tiene asignación no es necesario que ingreses los campos de nombre de usuario, rut, fecha de entrega, cargo y empresa. Solo completa los campos de modelo y valor de compra, selecciona el estado "Disponible" o "Dado de Baja" y guarda el registro.
                        </p>
    </div>
</div>