<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function index(Request $request, DocumentCategory $category)
    {
        $search = $request->input('search');

        // Obtener las subcarpetas de la categoría actual
        $subcategories = $category->children()
            ->where('is_active', true)
            ->withCount('documents')
            ->orderBy('name')
            ->get();

        // Obtener los documentos de la categoría actual
        $documents = $category->documents()
            ->where('is_active', true)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('file_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(50)
            ->withQueryString();

        return view(
            'documentacion.category',
            compact(
                'category',
                'subcategories',
                'documents',
                'search'
            )
        );
    }

    public function create(DocumentCategory $category)
    {
        return view(
            'documentacion.partials.document-upload-modal',
            compact('category')
        );
    }

    public function store(Request $request, DocumentCategory $category)
    {
        $files = $request->file('files', []);
        if (empty($files)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se recibieron archivos.',
                ], 422);
            }
            return back()
                ->with('error', 'No se recibieron archivos.');
        }
        $uploaded = 0;
        $failed = [];
        /*
        |--------------------------------------------------------------------------
        | PROCESAR CADA DOCUMENTO INDIVIDUALMENTE
        |--------------------------------------------------------------------------
        */
        foreach ($files as $index => $file) {
            $documentName =
                $request->input("names.$index");
            $description =
                $request->input("descriptions.$index");
            /*
            |--------------------------------------------------------------------------
            | VALIDAR DOCUMENTO
            |--------------------------------------------------------------------------
            */
            $validator = Validator::make(
                [
                    'file' => $file,
                    'name' => $documentName,
                    'description' => $description,
                ],
                [
                    'file' =>
                        'required|file|max:51200',
                    'name' =>
                        'required|string|max:255',
                    'description' =>
                        'nullable|string',
                ]
            );
            /*
            |--------------------------------------------------------------------------
            | SI ESTE DOCUMENTO TIENE ERROR
            |--------------------------------------------------------------------------
            */
            if ($validator->fails()) {
                $failed[] = [
                    'index' => $index,
                    'file_name' => $file
                        ? $file->getClientOriginalName()
                        : 'Archivo desconocido',
                    'name' => $documentName,
                    'errors' => $validator
                        ->errors()
                        ->all(),
                ];
                // Continuamos con el siguiente archivo
                continue;
            }
            /*
            |--------------------------------------------------------------------------
            | TRANSACCIÓN INDIVIDUAL
            |--------------------------------------------------------------------------
            */
            DB::beginTransaction();
            $storedPath = null;
            try {
                /*
                |--------------------------------------------------------------------------
                | GUARDAR ARCHIVO
                |--------------------------------------------------------------------------
                */
                $storedPath = $file->store(
                    'documentacion/' . $category->id,
                    'public'
                );
                /*
                |--------------------------------------------------------------------------
                | CREAR DOCUMENTO
                |--------------------------------------------------------------------------
                */
                $document = Document::create([
                    'category_id' => $category->id,
                    'name' => $documentName,
                    'description' => $description,
                    'file_path' => $storedPath,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                    'created_by' => auth()->id(),
                ]);
                /*
                |--------------------------------------------------------------------------
                | AUDITORÍA
                |--------------------------------------------------------------------------
                */
                AuditLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'created',
                    'description' =>
                        'Se ha subido el documento "' .
                        $document->name .
                        '"',
                    'old_values' => null,
                    'new_values' => [
                        'id' => $document->id,
                        'name' => $document->name,
                        'description' => $document->description,
                        'category_id' => $document->category_id,
                        'file_name' => $document->file_name,
                        'file_type' => $document->file_type,
                        'file_size' => $document->file_size,
                    ],
                ]);
                DB::commit();
                $uploaded++;
            } catch (\Throwable $e) {
                DB::rollBack();
                /*
                |--------------------------------------------------------------------------
                | ELIMINAR ARCHIVO SI ALCANZÓ A GUARDARSE
                |--------------------------------------------------------------------------
                */
                if (
                    $storedPath &&
                    Storage::disk('public')->exists($storedPath)
                ) {
                    Storage::disk('public')->delete(
                        $storedPath
                    );
                }
                /*
                |--------------------------------------------------------------------------
                | REGISTRAR ERROR
                |--------------------------------------------------------------------------
                */
                Log::error(
                    'Error al subir documento individual',
                    [
                        'category_id' => $category->id,
                        'user_id' => auth()->id(),
                        'file_name' =>
                            $file->getClientOriginalName(),
                        'error' => $e->getMessage(),
                    ]
                );
                /*
                |--------------------------------------------------------------------------
                | AGREGAR A FALLIDOS
                |--------------------------------------------------------------------------
                */
                $failed[] = [
                    'index' => $index,
                    'file_name' =>
                        $file->getClientOriginalName(),
                    'name' => $documentName,
                    'errors' => [
                        'No fue posible guardar el documento.',
                    ],
                ];
                // IMPORTANTE:
                // No detenemos el proceso.
                continue;
            }
        }
        /*
        |--------------------------------------------------------------------------
        | RESPUESTA AJAX
        |--------------------------------------------------------------------------
        */
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'uploaded' => $uploaded,
                'failed' => $failed,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PETICIÓN NORMAL
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route(
                'documentacion.category',
                $category
            )
            ->with(
                'success',
                "Se subieron {$uploaded} documento(s)."
            );
    }

    /**
     * Prepara la estructura de carpetas para una importación.
     */
    public function prepareFolderUpload(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => [
                'nullable',
                'integer',
                'exists:document_categories,id',
            ],

            'folders' => [
                'required',
                'array',
                'min:1',
            ],

            'folders.*' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $parentId = $validated['parent_id'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | CACHE DE CARPETAS CREADAS / ENCONTRADAS
        |--------------------------------------------------------------------------
        */
        $categoryMap = [];
        foreach ($validated['folders'] as $folderPath) {

            /*
            |--------------------------------------------------------------------------
            | NORMALIZAR RUTA
            |--------------------------------------------------------------------------
            */

            $folderPath = str_replace('\\', '/', $folderPath);
            $folderPath = trim($folderPath, '/');

            if ($folderPath === '') {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | EVITAR TRAVERSAL
            |--------------------------------------------------------------------------
            */

            $parts = explode('/', $folderPath);
            $parts = array_values(
                array_filter(
                    $parts,
                    fn ($part) => $part !== '' && $part !== '.' && $part !== '..'
                )
            );
            if (empty($parts)) {
                continue;
            }
            /*
            |--------------------------------------------------------------------------
            | CREAR CADA NIVEL DE LA ESTRUCTURA
            |--------------------------------------------------------------------------
            */

            $currentParentId = $parentId;
            $currentPath = '';
            foreach ($parts as $folderName) {

                $currentPath = $currentPath === ''
                    ? $folderName
                    : $currentPath . '/' . $folderName;

                /*
                |--------------------------------------------------------------------------
                | SI YA LA PROCESAMOS EN ESTA PETICIÓN
                |--------------------------------------------------------------------------
                */

                if (isset($categoryMap[$currentPath])) {
                    $currentParentId = $categoryMap[$currentPath];
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | BUSCAR SI YA EXISTE EN ESE NIVEL
                |--------------------------------------------------------------------------
                */

                $category = DocumentCategory::query()
                    ->where('name', $folderName)
                    ->where('parent_id', $currentParentId)
                    ->where('is_active', true)
                    ->first();

                /*
                |--------------------------------------------------------------------------
                | SI NO EXISTE, CREARLA
                |--------------------------------------------------------------------------
                */

                if (!$category) {
                    $category = DocumentCategory::create([
                        'name' => $folderName,
                        'description' => null,
                        'image' => null,
                        'created_by' => auth()->id(),
                        'parent_id' => $currentParentId,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | AUDITORÍA
                    |--------------------------------------------------------------------------
                    */
                    AuditLog::create([
                        'user_id' => auth()->id(),
                        'action' => 'create',
                        'description' =>
                            'Creación de carpeta "' .
                            $category->name .
                            '" mediante importación de carpeta',

                        'old_values' => null,

                        'new_values' => [
                            'id' => $category->id,
                            'name' => $category->name,
                            'description' => $category->description,
                            'image' => $category->image,
                            'parent_id' => $category->parent_id,
                            'created_by' => $category->created_by,
                        ],

                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]);
                }
                /*
                |--------------------------------------------------------------------------
                | GUARDAR EN MAPA
                |--------------------------------------------------------------------------
                */

                $categoryMap[$currentPath] = $category->id;

                $currentParentId = $category->id;
            }
        }

        $rootCategoryPath = array_key_first($categoryMap);

        return response()->json([
            'success' => true,
            'root_category_id' => $categoryMap[$rootCategoryPath] ?? null,
            'categories' => $categoryMap,
        ]);
    }

    /**
     * Sube un lote de archivos pertenecientes a una carpeta importada.
     */
    public function uploadFolderBatch(Request $request, DocumentCategory $category)
    {
        $files = $request->file('files', []);
        if (empty($files)) {
            return response()->json([
                'success' => false,
                'message' => 'No se recibieron archivos.',
            ], 422);
        }
        $uploaded = 0;
        $failed = [];

        foreach ($files as $index => $file) {

            /*
            |--------------------------------------------------------------------------
            | RUTA RELATIVA
            |--------------------------------------------------------------------------
            */

            $relativePath = $request->input(
                "relative_paths.$index"
            );
            if (!$relativePath) {
                $failed[] = [
                    'index' => $index,
                    'file_name' => $file->getClientOriginalName(),
                    'errors' => [
                        'No se recibió la ruta relativa del archivo.',
                    ],
                ];

                continue;
            }
            /*
            |--------------------------------------------------------------------------
            | VALIDAR ARCHIVO
            |--------------------------------------------------------------------------
            */
            $validator = Validator::make(
                [
                    'file' => $file,
                ],
                [
                    'file' => 'required|file|max:51200',
                ]
            );

            if ($validator->fails()) {
                $failed[] = [
                    'index' => $index,
                    'file_name' => $file->getClientOriginalName(),
                    'errors' => $validator->errors()->all(),
                ];
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | NORMALIZAR RUTA
            |--------------------------------------------------------------------------
            */

            $relativePath = str_replace('\\', '/', $relativePath);
            $relativePath = trim($relativePath, '/');
            $parts = explode('/', $relativePath);
            $parts = array_values(
                array_filter(
                    $parts,
                    fn ($part) => $part !== '' && $part !== '.' && $part !== '..'
                )
            );

            if (count($parts) < 2) {
                $failed[] = [
                    'index' => $index,
                    'file_name' => $file->getClientOriginalName(),
                    'errors' => [
                        'La ruta del archivo no contiene una carpeta válida.',
                    ],
                ];
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | OBTENER RUTA DE LA CARPETA
            |--------------------------------------------------------------------------
            */

            array_pop($parts);
            $folderPath = implode('/', $parts);

            /*
            |--------------------------------------------------------------------------
            | BUSCAR CATEGORÍA DESTINO
            |--------------------------------------------------------------------------
            */

            $folderParts = explode('/', $folderPath);
            $currentCategory = $category;
            foreach ($folderParts as $folderName) {
                /*
                | La primera carpeta debe ser la categoría recibida
                */
                if ($folderName === $currentCategory->name) {
                    continue;
                }
                $currentCategory = $currentCategory
                    ->children()
                    ->where('name', $folderName)
                    ->where('is_active', true)
                    ->first();

                if (!$currentCategory) {
                    $failed[] = [
                        'index' => $index,
                        'file_name' => $file->getClientOriginalName(),
                        'errors' => [
                            'No fue posible encontrar la carpeta destino.',
                        ],
                    ];
                    continue 2;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | GUARDAR DOCUMENTO
            |--------------------------------------------------------------------------
            */
            DB::beginTransaction();
            $storedPath = null;
            try {

                $storedPath = $file->store(
                    'documentacion/' . $currentCategory->id,
                    'public'
                );

                $document = Document::create([
                    'category_id' => $currentCategory->id,
                    'name' => pathinfo(
                        $file->getClientOriginalName(),
                        PATHINFO_FILENAME
                    ),
                    'description' => null,
                    'file_path' => $storedPath,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                    'created_by' => auth()->id(),
                ]);

                /*
                |--------------------------------------------------------------------------
                | AUDITORÍA
                |--------------------------------------------------------------------------
                */

                AuditLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'created',
                    'description' =>
                        'Se ha subido el documento "' .
                        $document->name .
                        '" mediante importación de carpeta',
                    'old_values' => null,
                    'new_values' => [
                        'id' => $document->id,
                        'name' => $document->name,
                        'description' => $document->description,
                        'category_id' => $document->category_id,
                        'file_name' => $document->file_name,
                        'file_type' => $document->file_type,
                        'file_size' => $document->file_size,
                    ],
                ]);

                DB::commit();
                $uploaded++;

            } catch (\Throwable $e) {
                DB::rollBack();
                if (
                    $storedPath &&
                    Storage::disk('public')->exists($storedPath)
                ) {
                    Storage::disk('public')->delete($storedPath);
                }

                Log::error(
                    'Error al subir documento mediante importación de carpeta',
                    [
                        'category_id' => $currentCategory->id ?? null,
                        'user_id' => auth()->id(),
                        'file_name' => $file->getClientOriginalName(),
                        'error' => $e->getMessage(),
                    ]
                );

                $failed[] = [
                    'index' => $index,
                    'file_name' => $file->getClientOriginalName(),
                    'errors' => [
                        'No fue posible guardar el documento.',
                    ],
                ];
            }
        }
        return response()->json([
            'success' => true,
            'uploaded' => $uploaded,
            'failed' => $failed,
        ]);
    }

    public function download(Document $document)
    {
        if (!$document->is_active) {
            abort(404);
        }
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'El archivo no existe.');
        }
        return Storage::disk('public')->download(
            $document->file_path,
            $document->file_name
        );
    }

    public function trash()
    {
        //cargamos la categoría a la que pertenece el documento
        $categories = DocumentCategory::onlyTrashed()
            ->withCount([
                'documents' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->latest('deleted_at')
            ->get();
        //preparamos el documento para enviarse a la papelera
        $documents = Document::onlyTrashed()
            ->with([
                'creator',
                'category' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->latest('deleted_at')
            ->get();
        return view(
            'documentacion.trash',
            compact(
                'categories',
                'documents'
            )
        );
    }

    public function update(Request $request, Document $document)
    {
        if (!$document->is_active) {
            abort(404);
        }
        //se valida el nombre y descripción del documento.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        // se rescata los nombres antiguos
        $oldValues = [
            'id' => $document->id,
            'name' => $document->name,
            'description' => $document->description,
        ];
        //se actualizan los datos del documento
        $document->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);
        //Auditoría de actualización del documento
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'description' =>
                'El documento "' .
                $document->name .
                '" ha sido actualizado',
            'old_values' => $oldValues,
            'new_values' => [
                'id' => $document->id,
                'name' => $document->name,
                'description' => $document->description,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        return redirect()
            ->route(
                'documentacion.category',
                $document->category_id
            )
            ->with(
                'success',
                'El documento fue actualizado correctamente.'
            );
    }
    
    public function destroy(Request $request, Document $document)
    {
        //Primero verificamos si el archivo no se haya eliminado antes
        if (!$document->is_active) {
            abort(404);
        }
        //preparamos los datos del documento
        $oldValues = [
            'id' => $document->id,
            'category_id' => $document->category_id,
            'name' => $document->name,
            'description' => $document->description,
            'file_path' => $document->file_path,
            'file_name' => $document->file_name,
            'file_type' => $document->file_type,
            'file_size' => $document->file_size,
            'created_by' => $document->created_by,
            'is_active' => $document->is_active,
            'deleted_with_category' => $document->deleted_with_category,
        ];
        //como este es eliminado directamente, sin carpeta, este no habilita el eliminado con categoría
        $document->deleted_with_category = false;
        $document->save();
        //Elimina el documento (se envía a papelera)
        $document->delete();
        //Creación de la auditoría    
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'description' =>
                'El documento "' .
                $document->name .
                '" ha sido enviado a la papelera',
            'old_values' => $oldValues,
            'new_values' => [
                'id' => $document->id,
                'name' => $document->name,
                'deleted_at' => $document->deleted_at,
                'deleted_with_category' => false,
            ],

            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('documentacion.category', $document->category_id)
            ->with(
                'success',
                'El documento fue enviado a la papelera.'
            );
    }
 
    public function restore(Request $request, $id)
    {
        //Buscamos el archivo en la papelera
        $document = Document::withTrashed()
            ->findOrFail($id);
        //Aquí validamos si el archivo está en papelera
        if (!$document->deleted_at) {
            abort(404);
        }
        //Recuperamos los datos del documento
        $oldValues = [
            'id' => $document->id,
            'category_id' => $document->category_id,
            'name' => $document->name,
            'description' => $document->description,
            'file_path' => $document->file_path,
            'file_name' => $document->file_name,
            'file_type' => $document->file_type,
            'file_size' => $document->file_size,
            'created_by' => $document->created_by,
            'is_active' => $document->is_active,
            'deleted_at' => $document->deleted_at,
            'deleted_with_category' => $document->deleted_with_category,
        ];
        //aquí procedemos a restaurar el archivo
        $document->restore();
        $document->is_active = true;
        $document->deleted_with_category = false;
        $document->save();
        //Creamos la auditoría de la restauración
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'reactivated',
            'description' =>
                'Documento "' .
                $document->name .
                '" restaurado',
            'old_values' => $oldValues,
            'new_values' => [
                'id' => $document->id,
                'name' => $document->name,
                'description' => $document->description,
                'is_active' => true,
                'deleted_at' => null,
                'deleted_with_category' => false,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        return redirect()
            ->route('documentacion.trash')
            ->with(
                'success',
                'El documento fue restaurado correctamente.'
            );
    }

    public function permanentDelete(Request $request, $id)
    {
        //Busca el documento en la papelera
        $document = Document::withTrashed()
            ->findOrFail($id);
        //Valida que si exista
        if (!$document->deleted_at) {
            abort(404);
        }
        // Guarda sus valores
        $oldValues = [
            'id' => $document->id,
            'category_id' => $document->category_id,
            'name' => $document->name,
            'description' => $document->description,
            'file_path' => $document->file_path,
            'file_name' => $document->file_name,
            'file_type' => $document->file_type,
            'file_size' => $document->file_size,
            'created_by' => $document->created_by,
            'is_active' => $document->is_active,
            'deleted_at' => $document->deleted_at,
            'deleted_with_category' => $document->deleted_with_category,
        ];
        //elimina el documento de la lista de la papelera
        if (
            $document->file_path &&
            Storage::disk('public')->exists($document->file_path)
        ) {
            Storage::disk('public')->delete(
                $document->file_path
            );
        }
        //lo deshabilita en la base de datos
        $document->is_active = false;
        $document->save();
        // registra la auditoría
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_permanently',
            'description' =>
                'Documento "' .
                $document->name .
                '" eliminado definitivamente',
            'old_values' => $oldValues,
            'new_values' => [
                'id' => $document->id,
                'name' => $document->name,
                'is_active' => false,
                'file_deleted' => true,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        return redirect()
            ->route('documentacion.trash')
            ->with(
                'success',
                'El documento fue eliminado definitivamente.'
            );
    }    
}