<?php

namespace App\Http\Controllers;

use App\Models\DocumentCategory;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class DocumentCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');

        $allowedSorts = [
            'name',
            'updated_at',
            'documents_count',
        ];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'name';
        }

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $categories = DocumentCategory::query()
            ->withCount('documents')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy($sort, $direction)
            ->get();

        return view('documentacion.index', compact(
            'categories',
            'search',
            'sort',
            'direction'
        ));
    }

    public function create()
    {
     //   
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:2048',
            ],
        ]);

        $imagePath = null;

        dd([
            'has_file' => $request->hasFile('image'),
            'file' => $request->file('image'),
            'real_path' => $request->file('image')?->getRealPath(),
            'tmp_dir' => sys_get_temp_dir(),
            'tmp_writable' => is_writable(sys_get_temp_dir()),
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('document-categories', 'public');
        }

        $category = DocumentCategory::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'created_by' => auth()->id(),
        ]);

        // Registrar auditoría
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'description' => 'Creación de carpeta "' . $category->name . '"',
            'old_values' => null,
            'new_values' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'image' => $category->image,
                'created_by' => $category->created_by,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('documentacion.index')
            ->with('success', 'La categoría fue creada correctamente.');
    }

    public function show(DocumentCategory $documentacion)
    {
        $documents = $documentacion->documents()
        ->orderBy('name')
        ->get();

        return view('documentacion.documents.index', compact(
            'documentacion',
            'documents'
        ));
    }

    public function edit(string $id)
    {
        //
    }

    
    public function update(Request $request, DocumentCategory $documentacion)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:2048',
            ],
            'remove_image' => [
                'nullable',
                'boolean',
            ],
        ]);

        // Guardamos los valores anteriores para la auditoría
        $oldValues = [
            'id' => $documentacion->id,
            'name' => $documentacion->name,
            'description' => $documentacion->description,
            'image' => $documentacion->image,
            'created_by' => $documentacion->created_by,
        ];

        /*
        |--------------------------------------------------------------------------
        | IMAGEN
        |--------------------------------------------------------------------------
        */

        // Si se sube una nueva imagen
        if ($request->hasFile('image')) {

            // Eliminar imagen anterior si existe
            if ($documentacion->image) {

                Storage::disk('public')->delete(
                    $documentacion->image
                );

            }

            // Guardar nueva imagen
            $documentacion->image = $request->file('image')
                ->store('document-categories', 'public');
        }

        // Si se solicita quitar la imagen personalizada
        elseif ($request->boolean('remove_image')) {

            if ($documentacion->image) {

                Storage::disk('public')->delete(
                    $documentacion->image
                );

            }

            $documentacion->image = null;
        }


        /*
        |--------------------------------------------------------------------------
        | DATOS
        |--------------------------------------------------------------------------
        */

        $documentacion->name = $validated['name'];

        $documentacion->description =
            $validated['description'] ?? null;


        $documentacion->save();


        /*
        |--------------------------------------------------------------------------
        | AUDITORÍA
        |--------------------------------------------------------------------------
        */

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'description' => 'Se ha actualizado la carpeta "' . $category->name . '"',

            'old_values' => $oldValues,

            'new_values' => [
                'id' => $documentacion->id,
                'name' => $documentacion->name,
                'description' => $documentacion->description,
                'image' => $documentacion->image,
                'created_by' => $documentacion->created_by,
            ],

            'ip_address' => $request->ip(),

            'user_agent' => $request->userAgent(),
        ]);


        return redirect()
            ->route('documentacion.index')
            ->with(
                'success',
                'La categoría fue actualizada correctamente.'
            );
    }

    public function trash()
    {
        /*
        |--------------------------------------------------------------------------
        | CATEGORÍAS ELIMINADAS
        |--------------------------------------------------------------------------
        */

        $categories = DocumentCategory::onlyTrashed()
            ->where('is_active', true)
            ->withCount([
                'documents' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->orderByDesc('deleted_at')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DOCUMENTOS ELIMINADOS
        |--------------------------------------------------------------------------
        */

        $documents = Document::withTrashed()
            ->whereNotNull('deleted_at')
            ->where('is_active', true)
            ->with([
                'creator',
                'category' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->orderByDesc('deleted_at')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | VISTA
        |--------------------------------------------------------------------------
        */

        return view(
            'documentacion.trash',
            compact(
                'categories',
                'documents'
            )
        );
    }

    public function destroy(Request $request, DocumentCategory $documentacion)
    {
        DB::transaction(function () use ($request, $documentacion) {
            /*
            |--------------------------------------------------------------------------
            | GUARDAR DATOS DE LA CATEGORÍA
            |--------------------------------------------------------------------------
            */
            $oldValues = [
                'id' => $documentacion->id,
                'name' => $documentacion->name,
                'description' => $documentacion->description,
                'image' => $documentacion->image,
                'created_by' => $documentacion->created_by,
            ];
            /*
            |--------------------------------------------------------------------------
            | ENVIAR DOCUMENTOS A LA PAPELERA
            |--------------------------------------------------------------------------
            */
            $documentacion->documents
                ->each(function ($document) use ($request, $documentacion) {

                    $documentOldValues = [
                        'id' => $document->id,
                        'category_id' => $document->category_id,
                        'name' => $document->name,
                        'description' => $document->description,
                        'file_name' => $document->file_name,
                        'file_type' => $document->file_type,
                        'file_size' => $document->file_size,
                        'created_by' => $document->created_by,
                    ];


                    /*
                    |--------------------------------------------------------------------------
                    | MARCAR QUE FUE ELIMINADO JUNTO CON LA CATEGORÍA
                    |--------------------------------------------------------------------------
                    */

                    $document->deleted_with_category = true;
                    $document->save();


                    /*
                    |--------------------------------------------------------------------------
                    | SOFT DELETE
                    |--------------------------------------------------------------------------
                    */

                    $document->delete();


                    /*
                    |--------------------------------------------------------------------------
                    | AUDITORÍA
                    |--------------------------------------------------------------------------
                    */

                    AuditLog::create([
                        'user_id' => auth()->id(),
                        'action' => 'deleted',

                        'description' =>
                            'Documento "' . $document->name .
                            '" enviado a la papelera debido a la eliminación de la categoría "' .
                            $documentacion->name . '"',

                        'old_values' => $documentOldValues,

                        'new_values' => [
                            'deleted_at' => $document->deleted_at,
                            'deleted_with_category' => true,
                            'category_name' => $documentacion->name,
                        ],

                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]);

                });
            /*
            |--------------------------------------------------------------------------
            | SOFT DELETE DE LA CATEGORÍA
            |--------------------------------------------------------------------------
            */
            $documentacion->delete();
            /*
            |--------------------------------------------------------------------------
            | AUDITORÍA DE LA CATEGORÍA
            |--------------------------------------------------------------------------
            */
            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',

                'description' =>
                    'Carpeta de "' .
                    $documentacion->name .
                    '" enviada a la papelera junto con sus documentos',

                'old_values' => $oldValues,

                'new_values' => [
                    'deleted_at' => $documentacion->deleted_at,
                ],

                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

        });

        return redirect()
            ->route('documentacion.index')
            ->with(
                'success',
                'La carpeta y sus documentos fueron enviados a la papelera.'
            );
    }

    public function restore(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $documentacion = DocumentCategory::withTrashed()
                ->findOrFail($id);
            /*
            |--------------------------------------------------------------------------
            | GUARDAR DATOS ANTES DE RESTAURAR
            |--------------------------------------------------------------------------
            */
            $oldValues = [
                'id' => $documentacion->id,
                'name' => $documentacion->name,
                'description' => $documentacion->description,
                'image' => $documentacion->image,
                'created_by' => $documentacion->created_by,
                'deleted_at' => $documentacion->deleted_at,
            ];
            /*
            |--------------------------------------------------------------------------
            | RESTAURAR CATEGORÍA
            |--------------------------------------------------------------------------
            */
            $documentacion->restore();
            /*
            |--------------------------------------------------------------------------
            | RESTAURAR DOCUMENTOS ELIMINADOS JUNTO CON LA CATEGORÍA
            |--------------------------------------------------------------------------
            */
            $documents = Document::onlyTrashed()
                ->where('category_id', $documentacion->id)
                ->where('deleted_with_category', true)
                ->get();
            foreach ($documents as $document) {
                $document->restore();
                // Ya no está eliminado junto con una categoría
                $document->deleted_with_category = false;
                $document->save();
            }
            /*
            |--------------------------------------------------------------------------
            | AUDITORÍA DE LA CATEGORÍA
            |--------------------------------------------------------------------------
            */
            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'reactivated',
                'description' =>
                    'La carpeta "' .
                    $documentacion->name .
                    '" restaurada junto con sus documentos',
                'old_values' => $oldValues,
                'new_values' => [
                    'id' => $documentacion->id,
                    'name' => $documentacion->name,
                    'description' => $documentacion->description,
                    'image' => $documentacion->image,
                    'created_by' => $documentacion->created_by,
                    'deleted_at' => null,
                    'documents_restored' => $documents->count(),
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        });
        return redirect()
            ->route('documentacion.index')
            ->with(
                'success',
                'La categoría y sus documentos fueron restaurados correctamente.'
            );
    }

   public function permanentDelete(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $documentacion = DocumentCategory::withTrashed()
                ->findOrFail($id);
            /*
            |--------------------------------------------------------------------------
            | DATOS DE LA CATEGORÍA
            |--------------------------------------------------------------------------
            */
            $oldValues = [
                'id' => $documentacion->id,
                'name' => $documentacion->name,
                'description' => $documentacion->description,
                'image' => $documentacion->image,
                'created_by' => $documentacion->created_by,
                'deleted_at' => $documentacion->deleted_at,
                'is_active' => $documentacion->is_active,
            ];
            /*
            |--------------------------------------------------------------------------
            | DOCUMENTOS DE LA CATEGORÍA
            |--------------------------------------------------------------------------
            */
            $documents = Document::withTrashed()
                ->where('category_id', $documentacion->id)
                ->where('is_active', true)
                ->get();
            foreach ($documents as $document) {
                $documentOldValues = [
                    'id' => $document->id,
                    'category_id' => $document->category_id,
                    'name' => $document->name,
                    'description' => $document->description,
                    'file_path' => $document->file_path,
                    'file_name' => $document->file_name,
                    'file_type' => $document->file_type,
                    'file_size' => $document->file_size,
                    'created_by' => $document->created_by,
                    'deleted_at' => $document->deleted_at,
                    'is_active' => $document->is_active,
                ];
                /*
                |--------------------------------------------------------------------------
                | DESACTIVAR DOCUMENTO
                |--------------------------------------------------------------------------
                */
                $document->is_active = false;
                $document->save();
                /*
                |--------------------------------------------------------------------------
                | AUDITORÍA DEL DOCUMENTO
                |--------------------------------------------------------------------------
                */
                AuditLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'deleted_permanently',
                    'description' =>
                        'Documento "' .
                        $document->name .
                        '" eliminado definitivamente junto con la categoría "' .
                        $documentacion->name .
                        '"',
                    'old_values' => $documentOldValues,
                    'new_values' => [
                        'id' => $document->id,
                        'name' => $document->name,
                        'is_active' => false,
                        'category_id' => $document->category_id,
                    ],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }
            /*
            |--------------------------------------------------------------------------
            | DESACTIVAR CATEGORÍA
            |--------------------------------------------------------------------------
            */
            $documentacion->is_active = false;
            $documentacion->save();
            /*
            |--------------------------------------------------------------------------
            | AUDITORÍA DE LA CATEGORÍA
            |--------------------------------------------------------------------------
            */
            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted_permanently',
                'description' =>
                    'Categoría de carpeta "' .
                    $documentacion->name .
                    '" eliminada definitivamente junto con sus documentos',
                'old_values' => $oldValues,
                'new_values' => [
                    'id' => $documentacion->id,
                    'name' => $documentacion->name,
                    'is_active' => false,
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        });
        return redirect()
            ->route('documentacion.trash')
            ->with(
                'success',
                'La categoría y sus documentos fueron eliminados definitivamente.'
            );
    }
}