<x-app-layout>

<div class="max-w-5xl p-6 mx-auto">

    {{-- Header --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Asignar Contraseña
        </h1>

        <p class="mt-1 text-sm text-gray-400">
            Crear nueva credencial corporativa
        </p>

    </div>

    {{-- Errors --}}
    @if ($errors->any())

        <div class="p-4 mb-6 border border-red-700 bg-red-900/40 rounded-xl">

            <ul class="space-y-1 text-sm text-red-300">

                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    <form
        method="POST"
        action="{{ route('passwords.store') }}"
        x-data="passwordGenerator()"
        class="space-y-6"
    >

        @csrf

        {{-- Información General --}}
        <div class="p-6 bg-gray-900 border border-gray-800 rounded-2xl">

            <h2 class="mb-5 text-lg font-semibold text-white">
                Información General
            </h2>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- Nombre --}}
                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Nombre Usuario
                    </label>

                    <input
                        type="text"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        required
                        class="w-full px-4 py-3 text-white bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >

                </div>

                {{-- Correo --}}
                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Correo
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-3 text-white bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >

                </div>

                {{-- Sucursal --}}
                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Sucursal
                    </label>

                    <select
                        name="branch_id"
                        class="w-full px-4 py-3 text-white bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >

                        <option value="">
                            Seleccionar sucursal
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

                {{-- Departamento --}}
                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Departamento
                    </label>

                    <select
                        name="department_id"
                        class="w-full px-4 py-3 text-white bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >

                        <option value="">
                            Seleccionar departamento
                        </option>

                        @foreach($departments as $department)

                            <option
                                value="{{ $department->id }}"
                                @selected(old('department_id') == $department->id)
                            >
                                {{ $department->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>

        {{-- Password --}}
        <div class="p-6 bg-gray-900 border border-gray-800 rounded-2xl">

            <div class="flex items-center justify-between mb-5">

                <h2 class="text-lg font-semibold text-white">
                    Contraseña
                </h2>

                <div class="text-xs text-gray-400">
                    Mínimo 12 • Máximo 20
                </div>

            </div>
            {{-- Tipo de contraseña --}}
            <div class="mb-6">

                <label class="block mb-3 text-sm text-gray-300">
                    Tipo de contraseña
                </label>

                <div class="flex flex-col gap-3 md:flex-row md:gap-6">

                    {{-- EXISTENTE --}}
                    <label class="flex items-center gap-2 text-sm text-gray-300">

                        <input
                            type="radio"
                            x-model="passwordMode"
                            value="existing"
                            class="text-blue-600 bg-gray-800 border-gray-700"
                        >

                        Usar contraseña existente

                    </label>

                    {{-- GENERAR --}}
                    <label class="flex items-center gap-2 text-sm text-gray-300">

                        <input
                            type="radio"
                            x-model="passwordMode"
                            value="generate"
                            class="text-blue-600 bg-gray-800 border-gray-700"
                        >

                        Generar nueva contraseña

                    </label>

                </div>

            </div>

            {{-- PASSWORD EXISTENTE --}}
            <div
                x-show="passwordMode === 'existing'"
                x-transition
            >

                <label class="block mb-2 text-sm text-gray-300">
                    Contraseña existente
                </label>

                <div class="relative">

                    <input
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        x-model="password"
                        class="w-full px-4 py-3 pr-12 text-white bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >

                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute text-gray-400 -translate-y-1/2 right-3 top-1/2 hover:text-white"
                    >

                        👁

                    </button>

                </div>

                <p class="mt-2 text-xs text-gray-400">
                    Puedes pegar una contraseña existente desde Excel, LastPass u otro sistema.
                </p>

            </div>

            {{-- GENERAR PASSWORD --}}
            <div
                x-show="passwordMode === 'generate'"
                x-transition
                class="space-y-5"
            >

                {{-- Longitud --}}
                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Longitud
                    </label>

                    <input
                        type="range"
                        min="12"
                        max="20"
                        x-model="length"
                        class="w-full"
                    >

                    <div class="mt-2 text-sm text-gray-400">
                        Caracteres:
                        <span x-text="length"></span>
                    </div>

                </div>

                {{-- Password Generada --}}
                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Contraseña generada
                    </label>

                    <div class="flex flex-col gap-3 md:flex-row">

                        <div class="relative flex-1">

                            <input
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                x-model="password"
                                class="w-full px-4 py-3 pr-12 text-white bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            >

                            {{-- Mostrar/Ocultar --}}
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute text-gray-400 -translate-y-1/2 right-3 top-1/2 hover:text-white"
                            >

                                👁

                            </button>

                        </div>

                        {{-- Generar --}}
                        <button
                            type="button"
                            @click="generatePassword()"
                            class="px-5 py-3 font-medium text-white transition bg-blue-600 rounded-xl hover:bg-blue-700"
                        >

                            Generar

                        </button>

                        {{-- Copiar --}}
                        <button
                            type="button"
                            @click="copyPassword()"
                            class="px-5 py-3 font-medium text-white transition bg-gray-700 rounded-xl hover:bg-gray-600"
                        >

                            Copiar

                        </button>

                    </div>

                </div>

            </div>


        {{-- Submit --}}
        <div class="flex justify-center pt-6">

            <button
                type="submit"
                class="px-10 py-3 font-semibold text-white transition bg-green-600 rounded-xl hover:bg-green-700 shadow-lg"
            >

                Guardar Credencial

            </button>

        </div>

    </form>

</div>

{{-- Alpine --}}
<script>

    function passwordGenerator() {

        return {

            passwordMode: 'existing',

            length: 12,

            password: '',

            showPassword: false,

            async generatePassword() {

                try {

                    const response = await fetch(
                        '{{ route('passwords.generate') }}',
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },

                            body: JSON.stringify({
                                length: this.length
                            })
                        }
                    );

                    const data = await response.json();

                    this.password = data.password;

                } catch (error) {

                    console.error(error);

                    alert('Error al generar contraseña');

                }

            },

            copyPassword() {

                if (!this.password) return;

                navigator.clipboard.writeText(this.password);

                alert('Contraseña copiada');

            }

        }

    }

</script>

</x-app-layout>