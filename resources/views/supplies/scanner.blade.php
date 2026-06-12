<x-app-layout>

    <div class="flex justify-end mb-4">

        <button
            id="toggleSidebarBtn"
            type="button"
            class="
                px-4 py-2
                rounded-xl
                bg-slate-700
                hover:bg-slate-600
                text-white
                flex items-center gap-2
            "
        >
            <i class="bi bi-layout-sidebar"></i>
            Menú
        </button>

    </div>

    <div class="max-w-5xl mx-auto">

        <div class="mb-8">

            <h1 class="text-3xl font-bold text-white">
                Movimiento por Escáner
            </h1>

            <p class="text-slate-400 mt-2">
                Escanea productos para ingresar o retirar stock.
            </p>

        </div>

        <div class="
            bg-gray-900
            border border-gray-800
            rounded-2xl
            p-6
        ">

            {{-- Tipo Movimiento --}}
            <div class="flex gap-6 mb-6">

                <label class="text-white">
                    <input
                        type="radio"
                        name="movement_type"
                        value="remove"
                        checked
                    >

                    Retirar
                </label>

                <label class="text-white">
                    <input
                        type="radio"
                        name="movement_type"
                        value="add"
                    >

                    Ingresar
                </label>

            </div>

            {{-- Input Scanner --}}
            <input
                id="barcodeInput"
                type="text"
                placeholder="Escanea un código..."
                class="
                    w-full
                    rounded-xl
                    bg-gray-800
                    border border-gray-700
                    text-white
                "
                autofocus
            >
            <div
                id="scannerStatus"
                class="hidden mt-4 rounded-xl p-4"
            ></div>
            {{-- Último producto leído --}}
            <div class="
                mt-6
                bg-gray-800
                border border-gray-700
                rounded-xl
                p-5
            ">

                <h2 class="
                    text-lg font-semibold
                    text-white mb-4
                ">
                    Último producto leído
                </h2>

                <div
                    id="lastScanned"
                    class="text-slate-400"
                >
                    Aún no se ha escaneado ningún producto.
                </div>

            </div>

            {{-- Productos escaneados --}}
            <div class="
                mt-6
                bg-gray-800
                border border-gray-700
                rounded-xl
                p-5
            ">

                <h2 class="
                    text-lg font-semibold
                    text-white mb-4
                ">
                    Productos escaneados
                </h2>

                <div
                    id="scannedItems"
                    class="space-y-2"
                >

                    <div class="text-slate-400">
                        No hay productos escaneados.
                    </div>

                </div>

            </div>

            {{-- Resumen --}}
            <div class="
                mt-6
                flex items-center justify-between
            ">

                <div
                    id="totalItems"
                    class="
                        text-lg
                        font-semibold
                        text-white
                    "
                >
                    Total artículos: 0
                </div>

                <div class="flex gap-3">

                    <button
                        type="button"
                        id="clearBtn"
                        class="
                            px-4 py-2
                            rounded-xl
                            bg-slate-700
                            hover:bg-slate-600
                            text-white
                        "
                    >
                        Limpiar
                    </button>

                    <button
                        type="button"
                        id="confirmBtn"
                        class="
                            px-4 py-2
                            rounded-xl
                            bg-green-600
                            hover:bg-green-700
                            text-white
                            font-semibold
                        "
                    >
                        Confirmar Movimiento
                    </button>

                </div>

            </div>

        </div>

    </div>
    <script>
        const barcodeInput =
            document.getElementById('barcodeInput');

        const scannedProducts = {};

        barcodeInput.addEventListener(
            'keydown',
            async (e) => {

                if (e.key !== 'Enter') {
                    return;
                }

                e.preventDefault();

                const barcode =
                    barcodeInput.value.trim();

                if (!barcode) {
                    return;
                }

                barcodeInput.value = '';

                try {

                    const response =
                        await fetch(
                            "{{ route('supplies.scanner.find') }}",
                            {
                                method: 'POST',

                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN':
                                        '{{ csrf_token() }}'
                                },

                                body: JSON.stringify({
                                    barcode
                                })
                            }
                        );

                    const data =
                        await response.json();

                    if (!data.success) {

                        setScannerStatus(
                            data.message,
                            'error'
                        );

                        return;
                    }

                    const lastScanned =
                        document.getElementById(
                            'lastScanned'
                        );

                    lastScanned.innerHTML = `
                        <div class="space-y-1">

                            <div class="font-semibold text-white">
                                ${data.supply.supply_type}
                            </div>

                            <div class="text-slate-300">
                                ${data.supply.brand}
                            </div>

                            <div class="text-slate-400">
                                ${data.supply.printer_model}
                            </div>

                            <div class="text-green-400">
                                Stock actual:
                                ${data.supply.quantity}
                            </div>

                        </div>
                    `;

                    const id =
                        data.supply.id;

                    if (!scannedProducts[id]) {

                        scannedProducts[id] = {
                            id: data.supply.id,
                            supply_type:
                                data.supply.supply_type,
                            quantity: 0
                        };

                    }

                    scannedProducts[id].quantity++;

                    setScannerStatus(
                        `${data.supply.supply_type} agregado correctamente.`
                    );

                    renderScannedItems();

                } catch (error) {

                    console.error(error);

                    setScannerStatus(
                        'Error al buscar el producto.',
                        'error'
                    );

                }

            }
        );

        function renderScannedItems()
        {
            const container =
                document.getElementById(
                    'scannedItems'
                );

            const totalItems =
                document.getElementById(
                    'totalItems'
                );

            container.innerHTML = '';

            let total = 0;

            Object.values(scannedProducts)
                .forEach(product => {

                    total += product.quantity;

                    container.innerHTML += `
                        <div class="
                            flex
                            justify-between
                            text-white
                            border-b
                            border-gray-700
                            py-2
                        ">
                            <span>
                                ${product.supply_type}
                            </span>

                            <span class="font-semibold">
                                x${product.quantity}
                            </span>
                        </div>
                    `;
                });

            totalItems.innerHTML =
                `Total artículos: ${total}`;
        }

        document.getElementById('clearBtn')
            .addEventListener('click', () => {

                Object.keys(scannedProducts)
                    .forEach(key => {
                        delete scannedProducts[key];
                    });

                document.getElementById(
                    'lastScanned'
                ).innerHTML =
                    'Aún no se ha escaneado ningún producto.';

                renderScannedItems();

                document.getElementById(
                    'scannerStatus'
                ).classList.add(
                    'hidden'
                );

                barcodeInput.focus();

            });

        document.getElementById('confirmBtn')
            .addEventListener('click', async () => {

                const items =
                    Object.values(scannedProducts);

                if (items.length === 0) {

                    setScannerStatus(
                        'No hay productos escaneados.',
                        'error'
                    );

                    return;
                }

                const movementType =
                    document.querySelector(
                        'input[name="movement_type"]:checked'
                    ).value;

                try {

                    const response =
                        await fetch(
                            "{{ route('supplies.scanner.process') }}",
                            {
                                method: 'POST',

                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN':
                                        '{{ csrf_token() }}'
                                },

                                body: JSON.stringify({
                                    type: movementType,
                                    items
                                })
                            }
                        );

                    const data =
                        await response.json();

                    if (!data.success) {

                        setScannerStatus(
                            data.message,
                            'error'
                        );

                        return;
                    }

                    setScannerStatus(
                        'Movimiento registrado correctamente.'
                    );

                    Object.keys(scannedProducts)
                        .forEach(key => {
                            delete scannedProducts[key];
                        });

                    document.getElementById(
                        'lastScanned'
                    ).innerHTML =
                        'Aún no se ha escaneado ningún producto.';

                    renderScannedItems();

                    barcodeInput.focus();

                } catch (error) {

                    console.error(error);

                    setScannerStatus(
                        'Error al registrar movimiento.',
                        'error'
                    );

                }

            });

        function setScannerStatus(
            message,
            type = 'success'
        )
        {
            const status =
                document.getElementById(
                    'scannerStatus'
                );

            status.textContent =
                message;

            status.classList.remove(
                'hidden',
                'bg-green-900',
                'text-green-300',
                'border-green-700',
                'bg-red-900',
                'text-red-300',
                'border-red-700'
            );

            if (type === 'success') {

                status.classList.add(
                    'bg-green-900',
                    'text-green-300',
                    'border',
                    'border-green-700'
                );

            } else {

                status.classList.add(
                    'bg-red-900',
                    'text-red-300',
                    'border',
                    'border-red-700'
                );

            }
        }

        document.addEventListener('DOMContentLoaded', () => {

            const sidebar =
                document.getElementById('sidebar');

            const button =
                document.getElementById('toggleSidebarBtn');

            if (!sidebar || !button) {
                return;
            }

            let hidden = false;

            button.addEventListener('click', () => {

                hidden = !hidden;

                if (hidden) {

                    sidebar.style.display = 'none';

                    button.innerHTML =
                        '<i class="bi bi-layout-sidebar"></i> Mostrar menú';

                } else {

                    sidebar.style.display = '';

                    button.innerHTML =
                        '<i class="bi bi-layout-sidebar"></i> Ocultar menú';

                }

            });

        });
    </script>
</x-app-layout>