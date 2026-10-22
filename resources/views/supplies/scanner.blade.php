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

            {{-- Modo de movimiento activo --}}
            <div class="mb-6">
                <div
                    id="movementMode"
                    class="rounded-2xl border-2 border-red-500
                        bg-red-950 p-6 text-center"
                >
                    <div class="text-sm uppercase tracking-widest text-slate-300">
                        Modo de operación
                    </div>

                    <div id="movementModeLabel"
                        class="mt-2 text-4xl font-black text-red-400">
                        RETIRAR
                    </div>

                    <div class="mt-2 text-slate-300">
                        Escanea los productos o un código de comando.
                    </div>
                </div>
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
                <div class="mt-6 flex flex-wrap items-center justify-between gap-4">
                    <div id="totalItems"
                        class="text-xl font-bold text-white">
                        Total artículos: 0
                    </div>

                    <div class="text-right">
                        <div class="text-sm text-slate-400">
                            Guardado automático por inactividad
                        </div>

                        <div id="autoSaveStatus"
                            class="mt-1 font-semibold text-emerald-400">
                            Esperando escaneos
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const barcodeInput = document.getElementById('barcodeInput');
        const scannedProducts = {};

        const COMMANDS = {
            RETIRAR: 'CMD-RETIRAR',
            INGRESAR: 'CMD-INGRESAR',
            GUARDAR: 'CMD-GUARDAR'
        };

        const CSRF_TOKEN = '{{ csrf_token() }}';

        let movementType = 'remove';
        let saveInProgress = false;
        let lastActivity = Date.now();
        let autoSaveTimer = null;

        const AUTO_SAVE_DELAY = 5 * 60 * 1000;
        const KEEP_ALIVE_DELAY = 4 * 60 * 1000;

        function scannedItems() {
            return Object.values(scannedProducts);
        }

        function clearScannedProducts() {
            Object.keys(scannedProducts).forEach(id => {
                delete scannedProducts[id];
            });
        }

        function setAutoSaveStatus(message, error = false) {
            const element = document.getElementById('autoSaveStatus');

            element.textContent = message;
            element.classList.toggle('text-red-400', error);
            element.classList.toggle('text-emerald-400', !error);
        }

        function updateMovementMode() {
            const panel = document.getElementById('movementMode');
            const label = document.getElementById('movementModeLabel');

            const isRemove = movementType === 'remove';

            label.textContent = isRemove ? 'RETIRAR' : 'INGRESAR';

            panel.classList.toggle('border-red-500', isRemove);
            panel.classList.toggle('bg-red-950', isRemove);
            panel.classList.toggle('border-emerald-500', !isRemove);
            panel.classList.toggle('bg-emerald-950', !isRemove);

            label.classList.toggle('text-red-400', isRemove);
            label.classList.toggle('text-emerald-400', !isRemove);
        }

        function renderScannedItems() {
            const container = document.getElementById('scannedItems');
            const totalElement = document.getElementById('totalItems');

            container.replaceChildren();

            let total = 0;

            scannedItems().forEach(product => {
                total += product.quantity;

                const row = document.createElement('div');
                row.className =
                    'flex justify-between text-white border-b ' +
                    'border-gray-700 py-2';

                const name = document.createElement('span');
                name.textContent = product.supply_type;

                const quantity = document.createElement('span');
                quantity.className = 'font-semibold';
                quantity.textContent = `x${product.quantity}`;

                row.append(name, quantity);
                container.appendChild(row);
            });

            if (total === 0) {
                const empty = document.createElement('div');
                empty.className = 'text-slate-400';
                empty.textContent = 'No hay productos pendientes.';
                container.appendChild(empty);
            }

            totalElement.textContent = `Total artículos: ${total}`;
        }

        function setScannerStatus(message, type = 'success') {
            const status = document.getElementById('scannerStatus');

            status.textContent = message;

            status.className = 'mt-4 rounded-xl border p-4 ' +
                (type === 'success'
                    ? 'border-green-700 bg-green-900 text-green-300'
                    : 'border-red-700 bg-red-900 text-red-300');
        }

        function resetAutoSaveTimer() {
            lastActivity = Date.now();

            clearTimeout(autoSaveTimer);

            autoSaveTimer = setTimeout(async () => {
                if (scannedItems().length > 0) {
                    setAutoSaveStatus('Guardando por inactividad...');
                    await saveMovement(true);
                } else {
                    setAutoSaveStatus('Sin productos pendientes');
                }
            }, AUTO_SAVE_DELAY);
        }

        async function saveMovement(automatic = false) {
            if (saveInProgress) {
                return false;
            }

            const items = scannedItems();

            if (items.length === 0) {
                if (!automatic) {
                    setScannerStatus('No hay productos pendientes.', 'error');
                }

                return true;
            }

            saveInProgress = true;
            setAutoSaveStatus('Guardando movimiento...');

            try {
                const response = await fetch(
                    "{{ route('supplies.scanner.process') }}",
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        body: JSON.stringify({
                            type: movementType,
                            items: items
                        })
                    }
                );

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const data = await response.json();

                if (!data.success) {
                    setScannerStatus(
                        data.message || 'No se pudo guardar el movimiento.',
                        'error'
                    );

                    setAutoSaveStatus('Guardado pendiente: revisar error', true);
                    return false;
                }

                clearScannedProducts();
                renderScannedItems();

                document.getElementById('lastScanned').textContent =
                    'Aún no se ha escaneado ningún producto.';

                setScannerStatus(
                    automatic
                        ? 'Movimiento guardado automáticamente.'
                        : 'Movimiento guardado correctamente.'
                );

                setAutoSaveStatus('Último lote guardado correctamente');

                return true;

            } catch (error) {
                console.error('Error guardando movimiento:', error);

                setScannerStatus(
                    'Error de conexión. Los productos siguen pendientes.',
                    'error'
                );

                setAutoSaveStatus('Error al guardar; lote pendiente', true);
                return false;

            } finally {
                saveInProgress = false;
                barcodeInput.focus();
            }
        }

        async function changeMovementMode(newMode) {
            if (newMode === movementType) {
                setScannerStatus(`El modo ${newMode === 'remove' ? 'RETIRAR' : 'INGRESAR'} ya está activo.`);
                return;
            }

            // Guardar primero el lote anterior.
            const saved = await saveMovement(false);

            if (!saved) {
                setScannerStatus(
                    'No se cambió el modo porque el lote anterior no se guardó.',
                    'error'
                );
                return;
            }

            movementType = newMode;
            updateMovementMode();
            resetAutoSaveTimer();

            setScannerStatus(
                `Modo cambiado a ${newMode === 'remove' ? 'RETIRAR' : 'INGRESAR'}.`
            );

            barcodeInput.focus();
        }

        async function handleBarcode(barcode) {
            const command = barcode
                .trim()
                .toUpperCase()
                .replace(/['’]/g, '-');

            if (command === COMMANDS.RETIRAR) {
                await changeMovementMode('remove');
                return;
            }

            if (command === COMMANDS.INGRESAR) {
                await changeMovementMode('add');
                return;
            }

            if (command === COMMANDS.GUARDAR) {
                await saveMovement(false);
                resetAutoSaveTimer();
                return;
            }

            // No procesar productos durante un guardado.
            if (saveInProgress) {
                setScannerStatus(
                    'Espera a que termine el guardado antes de escanear otro producto.',
                    'error'
                );
                return;
            }

            try {
                const response = await fetch(
                    "{{ route('supplies.scanner.find') }}",
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        body: JSON.stringify({ barcode })
                    }
                );

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const data = await response.json();

                if (!data.success) {
                    setScannerStatus(
                        data.message || 'No se encontró el producto.',
                        'error'
                    );
                    return;
                }

                const supply = data.supply;
                const id = supply.id;

                if (!scannedProducts[id]) {
                    scannedProducts[id] = {
                        id: supply.id,
                        supply_type: supply.supply_type,
                        quantity: 0
                    };
                }

                scannedProducts[id].quantity++;

                const lastScanned = document.getElementById('lastScanned');
                lastScanned.replaceChildren();

                const details = document.createElement('div');
                details.className = 'space-y-1';

                [
                    [supply.supply_type, 'font-semibold text-white'],
                    [supply.brand || '', 'text-slate-300'],
                    [supply.printer_model || '', 'text-slate-400'],
                    [`Stock actual: ${supply.quantity}`, 'text-emerald-400']
                ].forEach(([text, className]) => {
                    const line = document.createElement('div');
                    line.className = className;
                    line.textContent = text;
                    details.appendChild(line);
                });

                lastScanned.appendChild(details);

                renderScannedItems();

                setScannerStatus(
                    `${supply.supply_type} agregado al lote de ${
                        movementType === 'remove' ? 'retiro' : 'ingreso'
                    }.`
                );

                setAutoSaveStatus('Hay productos pendientes de guardar');
                resetAutoSaveTimer();

            } catch (error) {
                console.error('Error buscando producto:', error);

                setScannerStatus(
                    'Error de conexión al buscar el producto.',
                    'error'
                );
            }
        }

        barcodeInput.addEventListener('keydown', async event => {
            if (event.key !== 'Enter') {
                return;
            }

            event.preventDefault();

            const barcode = barcodeInput.value.trim();
            barcodeInput.value = '';

            if (!barcode) {
                barcodeInput.focus();
                return;
            }

            resetAutoSaveTimer();
            await handleBarcode(barcode);

            barcodeInput.focus();
        });

        // Mantener viva la sesión mientras el terminal siga abierto.
        setInterval(async () => {
            try {
                const response = await fetch(
                    "{{ route('supplies.scanner.keepalive') }}",
                    {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        }
                    }
                );

                if (response.status === 401 || response.status === 419) {
                    setScannerStatus(
                        'La sesión expiró. Vuelve a iniciar sesión.',
                        'error'
                    );
                }
            } catch (error) {
                console.error('Error manteniendo la sesión:', error);
            }
        }, KEEP_ALIVE_DELAY);

        // Ocultar/mostrar el menú lateral, si existe.
        const sidebar = document.getElementById('sidebar');
        const sidebarButton = document.getElementById('toggleSidebarBtn');

        if (sidebar && sidebarButton) {
            // Ocultar la sidebar al iniciar el terminal.
            let sidebarHidden = true;

            sidebar.style.display = 'none';

            sidebarButton.addEventListener('click', () => {
                sidebarHidden = !sidebarHidden;
                sidebar.style.display = sidebarHidden ? 'none' : '';
            });
        }

        updateMovementMode();
        renderScannedItems();
        resetAutoSaveTimer();
        barcodeInput.focus();
    </script>
</x-app-layout>