{{-- MODAL SUBIR CARPETA COMPLETA --}}

<div
    id="folder-upload-modal"
    class="hidden fixed inset-0 z-[80] items-center justify-center bg-black/50 px-4"
>
    <div
        class="
            w-full
            max-w-2xl
            rounded-2xl
            bg-white
            p-6
            shadow-2xl
            dark:bg-slate-900
        "
    >
        {{-- ENCABEZADO --}}
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    Subir carpeta completa
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Selecciona una carpeta de tu computador para conservar toda su estructura.
                </p>
            </div>

            <button
                type="button"
                id="close-folder-upload-modal"
                class="
                    rounded-lg
                    p-2
                    text-slate-400
                    hover:bg-slate-100
                    hover:text-slate-600
                    dark:hover:bg-slate-800
                    dark:hover:text-slate-200
                "
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>

        {{-- SELECTOR DE CARPETA --}}
        <div class="mt-6">
            <label
                for="folder-upload-input"
                id="folder-drop-zone"
                class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 px-6 py-10 text-center transition hover:border-emerald-500 hover:bg-emerald-50 dark:border-slate-700 dark:hover:border-emerald-500 dark:hover:bg-emerald-950/20"
            >
                <img
                    src="{{ asset('images/documentacion/carpeta.png') }}"
                    alt="Seleccionar carpeta"
                    id="folder-drop-icon"
                    class="h-14 w-14 object-contain"
                >
                <span class="mt-4 text-sm font-semibold text-slate-700 dark:text-slate-200" id="folder-drop-title">
                    Seleccionar carpeta
                </span>
                <span class="mt-1 text-xs text-slate-500 dark:text-slate-400" id="folder-drop-description">
                    O arrastra una carpeta aquí
                </span>
            </label>

            <input
                type="file"
                id="folder-upload-input"
                webkitdirectory
                directory
                multiple
                class="hidden"
            >
        </div>

        {{-- INFORMACIÓN DE LA SELECCIÓN --}}
        <div
            id="folder-upload-info"
            class="mt-4 hidden rounded-xl bg-slate-100 p-4 dark:bg-slate-800"
        >
            <p
                id="folder-upload-name"
                class="font-semibold text-slate-800 dark:text-slate-100"
            ></p>

            <p
                id="folder-upload-count"
                class="mt-1 text-sm text-slate-500 dark:text-slate-400"
            ></p>
        </div>

        {{-- PROGRESO --}}
        <div
            id="folder-upload-progress-container"
            class="mt-5 hidden"
        >
            <div class="flex items-center justify-between text-sm">
                <span class="text-slate-600 dark:text-slate-300">
                    Subiendo archivos...
                </span>

                <span
                    id="folder-upload-progress-text"
                    class="font-semibold text-slate-700 dark:text-slate-200"
                >
                    0 / 0
                </span>
            </div>

            <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-700">
                <div
                    id="folder-upload-progress-bar"
                    class="h-full rounded-full bg-emerald-600 transition-all duration-300"
                    style="width: 0%"
                ></div>
            </div>
        </div>

        {{-- ERROR --}}
        <div
            id="folder-upload-error"
            class="mt-4 hidden rounded-xl bg-red-50 p-4 text-sm text-red-700 dark:bg-red-950/30 dark:text-red-400"
        ></div>

        {{-- BOTONES --}}
        <div class="mt-6 flex justify-end gap-3">
            <button
                type="button"
                id="cancel-folder-upload-modal"
                class="
                    rounded-xl
                    border
                    border-slate-300
                    px-4
                    py-2.5
                    text-sm
                    font-semibold
                    text-slate-700
                    transition
                    hover:bg-slate-100
                    dark:border-slate-700
                    dark:text-slate-200
                    dark:hover:bg-slate-800
                "
            >
                Cancelar
            </button>

            <button
                type="button"
                id="submit-folder-upload"
                disabled
                class="
                    rounded-xl
                    bg-emerald-600
                    px-4
                    py-2.5
                    text-sm
                    font-semibold
                    text-white
                    transition
                    hover:bg-emerald-700
                    disabled:cursor-not-allowed
                    disabled:opacity-50
                "
            >
                Subir carpeta
            </button>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('folder-upload-modal');
        const openButton = document.getElementById('open-folder-upload-modal');
        const closeButton = document.getElementById('close-folder-upload-modal');
        const cancelButton = document.getElementById('cancel-folder-upload-modal');
        const input = document.getElementById('folder-upload-input');
        const dropZone = document.getElementById('folder-drop-zone');
        const dropTitle = document.getElementById('folder-drop-title');
        const dropDescription = document.getElementById('folder-drop-description');
        const submitButton = document.getElementById('submit-folder-upload');

        const info = document.getElementById('folder-upload-info');
        const folderName = document.getElementById('folder-upload-name');
        const folderCount = document.getElementById('folder-upload-count');

        const progressContainer = document.getElementById('folder-upload-progress-container');
        const progressText = document.getElementById('folder-upload-progress-text');
        const progressBar = document.getElementById('folder-upload-progress-bar');
        const errorBox = document.getElementById('folder-upload-error');

        const folderPrepareUrl = @json(route('documentacion.folder.prepare'));
        const folderParentCategoryId = @json($parentCategoryId);
        const folderCsrfToken = @json(csrf_token());

        const BATCH_SIZE = 15;

        let selectedFiles = [];
        let uploading = false;

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            if (uploading) return;

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            resetFolderUpload();
        }

        function resetFolderUpload() {
            input.value = '';
            selectedFiles = [];
            uploading = false;

            info.classList.add('hidden');
            progressContainer.classList.add('hidden');
            errorBox.classList.add('hidden');

            folderName.textContent = '';
            folderCount.textContent = '';
            errorBox.innerHTML = '';

            progressText.textContent = '0 / 0';
            progressBar.style.width = '0%';

            submitButton.disabled = true;
            submitButton.textContent = 'Subir carpeta';
        }

        function setUploadingState(state) {
            uploading = state;
            input.disabled = state;
            submitButton.disabled = state;
            closeButton.disabled = state;
            cancelButton.disabled = state;

            if (state) {
                submitButton.textContent = 'Subiendo...';
            } else {
                submitButton.textContent = 'Subir carpeta';
            }
        }

        function getFolderPaths(files) {
            const folders = new Set();

            files.forEach(file => {
                const path = file.relativePath || file.webkitRelativePath || file.name;
                const parts = path.split('/').filter(Boolean);

                if (parts.length < 2) {
                    return;
                }

                let currentPath = '';

                for (let i = 0; i < parts.length - 1; i++) {
                    currentPath = currentPath
                        ? `${currentPath}/${parts[i]}`
                        : parts[i];

                    folders.add(currentPath);
                }
            });

            return Array.from(folders).sort((a, b) => {
                const depthA = a.split('/').length;
                const depthB = b.split('/').length;

                if (depthA !== depthB) {
                    return depthA - depthB;
                }

                return a.localeCompare(b);
            });
        }

        async function prepareFolders(folders) {
            const formData = new FormData();

            if (folderParentCategoryId !== null) {
                formData.append('parent_id', folderParentCategoryId);
            }

            folders.forEach(folder => {
                formData.append('folders[]', folder);
            });

            const response = await fetch(folderPrepareUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': folderCsrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'No fue posible preparar las carpetas.');
            }

            return data;
        }

        async function uploadBatch(rootCategoryId, files) {
            const formData = new FormData();

            files.forEach((file, index) => {
                formData.append(`files[${index}]`, file);
                formData.append(
                    `relative_paths[${index}]`,
                    file.relativePath || file.webkitRelativePath || file.name
                );
            });

            const uploadUrl = `/documentacion/${rootCategoryId}/upload-folder`;

            const response = await fetch(uploadUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': folderCsrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Error al subir el lote de archivos.');
            }

            return data;
        }

        function setDropZoneActive(active) {
            if (active) {
                dropZone.classList.add('border-emerald-500', 'bg-emerald-50', 'dark:bg-emerald-950/30');
                dropTitle.textContent = 'Suelta la carpeta aquí';
                dropDescription.textContent = 'Se conservarán todas las subcarpetas y archivos';
            } else {
                dropZone.classList.remove('border-emerald-500', 'bg-emerald-50', 'dark:bg-emerald-950/30');
                dropTitle.textContent = 'Seleccionar carpeta';
                dropDescription.textContent = 'O arrastra una carpeta aquí';
            }
        }

        function readDirectoryEntry(entry, currentPath = '') {
            return new Promise((resolve, reject) => {
                if (entry.isFile) {
                    entry.file(file => {
                        file.relativePath = currentPath
                            ? `${currentPath}/${file.name}`
                            : file.name;

                        resolve([file]);
                    }, reject);

                    return;
                }

                if (entry.isDirectory) {
                    const directoryPath = currentPath
                        ? `${currentPath}/${entry.name}`
                        : entry.name;

                    const reader = entry.createReader();
                    const entries = [];

                    const readEntries = () => {
                        reader.readEntries(async batch => {
                            if (!batch.length) {
                                try {
                                    const results = await Promise.all(
                                        entries.map(child =>
                                            readDirectoryEntry(child, directoryPath)
                                        )
                                    );

                                    resolve(results.flat());
                                } catch (error) {
                                    reject(error);
                                }

                                return;
                            }

                            entries.push(...batch);
                            readEntries();
                        }, reject);
                    };

                    readEntries();
                }
            });
        }

        async function getDroppedFiles(dataTransfer) {
            const items = Array.from(dataTransfer.items || []);

            if (!items.length) {
                return [];
            }

            const entries = items
                .map(item => item.webkitGetAsEntry?.())
                .filter(Boolean);

            if (!entries.length) {
                return [];
            }

            if (entries.some(entry => !entry.isDirectory)) {
                throw new Error('Debes arrastrar una carpeta completa, no archivos individuales.');
            }

            const results = await Promise.all(
                entries.map(entry => readDirectoryEntry(entry))
            );

            return results.flat();
        }

        function setSelectedFiles(files) {
            selectedFiles = files;

            if (!selectedFiles.length) {
                resetFolderUpload();
                return;
            }

            const firstPath =
                selectedFiles[0].relativePath ||
                selectedFiles[0].webkitRelativePath ||
                selectedFiles[0].name;

            const rootFolderName = firstPath.split('/')[0];

            folderName.textContent = rootFolderName;
            folderCount.textContent =
                `${selectedFiles.length} archivo${selectedFiles.length === 1 ? '' : 's'} encontrado${selectedFiles.length === 1 ? '' : 's'}.`;

            info.classList.remove('hidden');
            errorBox.classList.add('hidden');
            progressContainer.classList.add('hidden');

            submitButton.disabled = false;
        }

        async function uploadFolder() {
            if (!selectedFiles.length || uploading) {
                return;
            }

            setUploadingState(true);
            errorBox.classList.add('hidden');
            errorBox.innerHTML = '';

            try {
                const folders = getFolderPaths(selectedFiles);

                if (!folders.length) {
                    throw new Error('La carpeta seleccionada no contiene una estructura válida.');
                }

                progressContainer.classList.remove('hidden');
                progressText.textContent = 'Preparando carpetas...';
                progressBar.style.width = '0%';

                const prepared = await prepareFolders(folders);

                const rootCategoryId = prepared.root_category_id;

                if (!rootCategoryId) {
                    throw new Error('No se pudo determinar la carpeta raíz.');
                }

                const totalFiles = selectedFiles.length;
                let uploadedFiles = 0;
                const failedFiles = [];

                for (let i = 0; i < selectedFiles.length; i += BATCH_SIZE) {
                    const batch = selectedFiles.slice(i, i + BATCH_SIZE);

                    progressText.textContent =
                        `Subiendo ${uploadedFiles} / ${totalFiles}...`;

                    const result = await uploadBatch(rootCategoryId, batch);

                    if (Array.isArray(result.uploaded)) {
                        uploadedFiles += result.uploaded.length;
                    } else {
                        uploadedFiles += batch.length;
                    }

                    if (Array.isArray(result.failed)) {
                        failedFiles.push(...result.failed);
                    }

                    const percentage = Math.round(
                        (uploadedFiles / totalFiles) * 100
                    );

                    progressText.textContent =
                        `${uploadedFiles} / ${totalFiles}`;

                    progressBar.style.width = `${percentage}%`;
                }

                if (failedFiles.length) {
                    errorBox.classList.remove('hidden');
                    errorBox.innerHTML = `
                        <strong>La carpeta se procesó, pero algunos archivos no pudieron subirse.</strong>
                        <div class="mt-2">
                            ${failedFiles.map(item => {
                                const name = item.file || item.name || 'Archivo desconocido';
                                const reason = item.error || item.message || 'Error desconocido';

                                return `
                                    <div class="mt-1">
                                        <strong>${escapeHtml(name)}</strong>: ${escapeHtml(reason)}
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    `;

                    submitButton.disabled = true;
                    submitButton.textContent = 'Proceso terminado';

                    return;
                }

                progressText.textContent =
                    `${totalFiles} / ${totalFiles} — Completado`;

                progressBar.style.width = '100%';

                submitButton.textContent = 'Completado';

                setTimeout(() => {
                    window.location.reload();
                }, 800);

            } catch (error) {
                console.error(error);

                errorBox.classList.remove('hidden');
                errorBox.textContent =
                    error.message || 'Ocurrió un error durante la carga.';

                setUploadingState(false);
            }
        }

        function escapeHtml(value) {
            const div = document.createElement('div');
            div.textContent = value ?? '';
            return div.innerHTML;
        }

        openButton?.addEventListener('click', openModal);
        closeButton?.addEventListener('click', closeModal);
        cancelButton?.addEventListener('click', closeModal);

        input?.addEventListener('change', () => {
            const files = Array.from(input.files || []);

            files.forEach(file => {
                file.relativePath = file.webkitRelativePath || file.name;
            });

            setSelectedFiles(files);
        });

        submitButton?.addEventListener('click', uploadFolder);

        dropZone?.addEventListener('dragenter', event => {
            event.preventDefault();
            event.stopPropagation();

            setDropZoneActive(true);
        });

        dropZone?.addEventListener('dragover', event => {
            event.preventDefault();
            event.stopPropagation();

            event.dataTransfer.dropEffect = 'copy';
            setDropZoneActive(true);
        });

        dropZone?.addEventListener('dragleave', event => {
            event.preventDefault();
            event.stopPropagation();

            if (!dropZone.contains(event.relatedTarget)) {
                setDropZoneActive(false);
            }
        });

        dropZone?.addEventListener('drop', async event => {
            event.preventDefault();
            event.stopPropagation();

            setDropZoneActive(false);

            if (uploading) {
                return;
            }

            try {
                const files = await getDroppedFiles(event.dataTransfer);

                if (!files.length) {
                    throw new Error('La carpeta seleccionada no contiene archivos.');
                }

                setSelectedFiles(files);
            } catch (error) {
                console.error(error);

                errorBox.classList.remove('hidden');
                errorBox.textContent =
                    error.message || 'No fue posible leer la carpeta.';
            }
        });
    });
</script>