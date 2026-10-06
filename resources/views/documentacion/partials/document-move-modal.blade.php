{{-- MODAL MOVER DOCUMENTO --}}
<div
    id="document-move-modal"
    class="hidden fixed inset-0 z-[80] items-center justify-center bg-black/50 px-4"
>
    <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-2xl dark:bg-slate-900">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    Mover documento
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Selecciona la carpeta donde quieres mover este documento.
                </p>
            </div>

            <button
                type="button"
                id="close-document-move-modal"
                class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-800 dark:hover:text-slate-200"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="mt-5 rounded-xl bg-slate-100 p-4 dark:bg-slate-800">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">
                Documento
            </p>
            <p id="document-move-name" class="mt-1 font-semibold text-slate-800 dark:text-slate-100"></p>
        </div>

        <div class="mt-5">
            <div
                id="document-move-loading"
                class="py-8 text-center text-sm text-slate-500 dark:text-slate-400"
            >
                Cargando carpetas...
            </div>

            <div
                id="document-move-error"
                class="hidden rounded-xl bg-red-50 p-4 text-sm text-red-700 dark:bg-red-950/30 dark:text-red-400"
            ></div>

            <div
                id="document-move-tree"
                class="hidden max-h-80 overflow-y-auto rounded-xl border border-slate-200 bg-white p-3 dark:border-slate-700 dark:bg-slate-900"
            ></div>
        </div>

        <input
            type="hidden"
            id="document-move-category-id"
            value=""
        >

        <div class="mt-6 flex justify-end gap-3">
            <button
                type="button"
                id="cancel-document-move-modal"
                class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800"
            >
                Cancelar
            </button>

            <button
                type="button"
                id="submit-document-move"
                disabled
                class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-50"
            >
                Mover aquí
            </button>
        </div>
    </div>
</div>
<script>
    (() => {
        const modal = document.getElementById('document-move-modal');
        const closeButton = document.getElementById('close-document-move-modal');
        const cancelButton = document.getElementById('cancel-document-move-modal');
        const documentName = document.getElementById('document-move-name');
        const loading = document.getElementById('document-move-loading');
        const errorBox = document.getElementById('document-move-error');
        const tree = document.getElementById('document-move-tree');
        const categoryIdInput = document.getElementById('document-move-category-id');
        const submitButton = document.getElementById('submit-document-move');

        let currentDocumentId = null;
        let categories = [];

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            currentDocumentId = null;
            categories = [];
            categoryIdInput.value = '';
            submitButton.disabled = true;
            tree.innerHTML = '';
            tree.classList.add('hidden');
            errorBox.classList.add('hidden');
            errorBox.textContent = '';
        }

        function escapeHtml(value) {
            const div = document.createElement('div');
            div.textContent = value ?? '';
            return div.innerHTML;
        }

        function buildTree(categories) {
            const map = new Map();
            const roots = [];

            categories.forEach(category => {
                map.set(category.id, {
                    ...category,
                    children: []
                });
            });

            categories.forEach(category => {
                const node = map.get(category.id);

                if (category.parent_id && map.has(category.parent_id)) {
                    map.get(category.parent_id).children.push(node);
                } else {
                    roots.push(node);
                }
            });

            const sortNodes = nodes => {
                nodes.sort((a, b) => a.name.localeCompare(b.name, 'es'));

                nodes.forEach(node => {
                    sortNodes(node.children);
                });
            };

            sortNodes(roots);

            return roots;
        }

        function renderTree(nodes, level = 0) {
            return nodes.map(node => {
                const hasChildren = node.children.length > 0;

                return `
                    <div class="document-move-node">
                        <button
                            type="button"
                            class="document-move-folder flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800"
                            data-category-id="${node.id}"
                            style="padding-left: ${12 + (level * 24)}px;"
                        >
                            <span class="shrink-0">
                                <svg class="h-5 w-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7.5A2.5 2.5 0 015.5 5h4l2 2H18.5A2.5 2.5 0 0121 9.5v7A2.5 2.5 0 0118.5 19h-13A2.5 2.5 0 013 16.5v-9z"/>
                                </svg>
                            </span>

                            <span class="min-w-0 flex-1 truncate">
                                ${escapeHtml(node.name)}
                            </span>

                            ${hasChildren ? `
                                <span class="text-xs text-slate-400">
                                    ${node.children.length}
                                </span>
                            ` : ''}
                        </button>

                        ${hasChildren ? `
                            <div>
                                ${renderTree(node.children, level + 1)}
                            </div>
                        ` : ''}
                    </div>
                `;
            }).join('');
        }

        function selectCategory(categoryId, button) {
            tree.querySelectorAll('.document-move-folder').forEach(folder => {
                folder.classList.remove(
                    'bg-emerald-100',
                    'text-emerald-800',
                    'dark:bg-emerald-950/40',
                    'dark:text-emerald-300'
                );
            });

            button.classList.add(
                'bg-emerald-100',
                'text-emerald-800',
                'dark:bg-emerald-950/40',
                'dark:text-emerald-300'
            );

            categoryIdInput.value = categoryId;
            submitButton.disabled = false;
        }

        async function loadCategories() {
            loading.classList.remove('hidden');
            tree.classList.add('hidden');
            errorBox.classList.add('hidden');
            errorBox.textContent = '';
            submitButton.disabled = true;
            categoryIdInput.value = '';

            try {
                const response = await fetch(
                    `/documentacion/documentos/${currentDocumentId}/move-targets`,
                    {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                );

                if (!response.ok) {
                    throw new Error('No fue posible cargar las carpetas.');
                }

                const data = await response.json();

                categories = data.targets || [];

                loading.classList.add('hidden');

                if (!categories.length) {
                    errorBox.textContent = 'No existen otras carpetas disponibles para mover este documento.';
                    errorBox.classList.remove('hidden');
                    return;
                }

                const treeData = buildTree(categories);

                tree.innerHTML = renderTree(treeData);
                tree.classList.remove('hidden');

                tree.querySelectorAll('.document-move-folder').forEach(button => {
                    button.addEventListener('click', () => {
                        selectCategory(button.dataset.categoryId, button);
                    });
                });
            } catch (error) {
                loading.classList.add('hidden');
                errorBox.textContent = error.message || 'Ocurrió un error al cargar las carpetas.';
                errorBox.classList.remove('hidden');
            }
        }

        window.openDocumentMoveModal = function(button) {
            currentDocumentId = button.dataset.documentId;

            documentName.textContent = button.dataset.documentName || 'Documento';

            openModal();
            loadCategories();
        };

        closeButton.addEventListener('click', closeModal);
        cancelButton.addEventListener('click', closeModal);

        modal.addEventListener('click', event => {
            if (event.target === modal) {
                closeModal();
            }
        });

        submitButton.addEventListener('click', async () => {
            const categoryId = categoryIdInput.value;

            if (!currentDocumentId || !categoryId) {
                return;
            }

            submitButton.disabled = true;
            submitButton.textContent = 'Moviendo...';

            try {
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('category_id', categoryId);

                const response = await fetch(
                    `/documentacion/documentos/${currentDocumentId}/move`,
                    {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    }
                );

                if (!response.ok) {
                    throw new Error('No fue posible mover el documento.');
                }

                window.location.reload();
            } catch (error) {
                submitButton.disabled = false;
                submitButton.textContent = 'Mover aquí';

                errorBox.textContent = error.message || 'Ocurrió un error al mover el documento.';
                errorBox.classList.remove('hidden');
            }
        });
    })();
</script>