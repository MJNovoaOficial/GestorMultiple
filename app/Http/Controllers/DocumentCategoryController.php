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

        $documentacion->name = $validated['name'];

        $documentacion->description =
            $validated['description'] ?? null;
        $documentacion->save();

        //auditamos la actualización de la carpeta
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'description' => 'Se ha actualizado la carpeta "' . $documentacion->name . '"',
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
        //Muestra listado de categorías o carpetas eliminadas (carga la papelera)
        $categories = DocumentCategory::onlyTrashed()
            ->where('is_active', true)
            ->withCount([
                'documents' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->orderByDesc('deleted_at')
            ->get();

        //Muestra listado de documentos eliminados pertenecientes a una categoría (carga la papelera también)
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
            //almacenamos la info que eliminamos
            $oldValues = [
                'id' => $documentacion->id,
                'name' => $documentacion->name,
                'description' => $documentacion->description,
                'image' => $documentacion->image,
                'created_by' => $documentacion->created_by,
            ];
            //aquí procedemos de enviar el documento con sus datos a la papelera.
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
                    //Aquí le asignamos que el documento fue eliminado porque se eliminó la carpeta completa
                    $document->deleted_with_category = true;
                    //guardamos los datos anteriores en DB
                    $document->save();
                    //hace el proceso de enviarlo a papelera
                    $document->delete();
                    //Auditamos el documento eliminado
                    AuditLog::create([
                        'user_id' => auth()->id(),
                        'action' => 'deleted',
                        'description' =>
                            'EL documento "' . $document->name .
                            '" fue enviado a la papelera porque se eliminó la carpeta "' .
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
            //Enviamos a la papelera la carpeta completa, ósea hacemos un soft delete
            $documentacion->delete();
            //Auditamos el proceso de eliminación
            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'description' =>
                    'La carpeta "' .
                    $documentacion->name .
                    '" fue enviada a la papelera junto con sus documentos',

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
            //guardamos los valores para después auditar y restaurar
            $oldValues = [
                'id' => $documentacion->id,
                'name' => $documentacion->name,
                'description' => $documentacion->description,
                'image' => $documentacion->image,
                'created_by' => $documentacion->created_by,
                'deleted_at' => $documentacion->deleted_at,
            ];
            //procedemos a restaurar la carpeta
            $documentacion->restore();
            //restauramos los documentos dentro de la carpeta (en caso de que los haya)
            $documents = Document::onlyTrashed()
                ->where('category_id', $documentacion->id)
                ->where('deleted_with_category', true)
                ->get();
            foreach ($documents as $document) {
                $document->restore();
                // Cambiamos el estado de eliminado a disponible
                $document->deleted_with_category = false;
                $document->save();
            }
            //Auditamos la restauración
            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'reactivated',
                'description' =>
                    'La carpeta "' .
                    $documentacion->name .
                    '" fue restaurada junto con sus documentos',
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
            //preparamos valores antes de hacer la eliminación definitiva
            $oldValues = [
                'id' => $documentacion->id,
                'name' => $documentacion->name,
                'description' => $documentacion->description,
                'image' => $documentacion->image,
                'created_by' => $documentacion->created_by,
                'deleted_at' => $documentacion->deleted_at,
                'is_active' => $documentacion->is_active,
            ];
            //Buscamos si dentro de la carpeta hay documentos
            $documents = Document::withTrashed()
                ->where('category_id', $documentacion->id)
                ->where('is_active', true)
                ->get();
            foreach ($documents as $document) {
                //en caso de haber documentos preparamos estos documentos para su eliminación definitiva
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
                //Eliminamos el documento (solo en la interfaz visual del usuario)
                $document->is_active = false;
                $document->save();
                
                //Se audita la eliminación
                AuditLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'deleted_permanently',
                    'description' =>
                        'El documento "' .
                        $document->name .
                        '" fue eliminado definitivamente porque se borró la categoría "' .
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
            //procedemos a eliminar la carpeta completa (recordemos que se borra de la interfaz del usuario)
            $documentacion->is_active = false;
            $documentacion->save();
            //Auditamos que borramos la carpeta
            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted_permanently',
                'description' =>
                    'LA carpeta "' .
                    $documentacion->name .
                    '" fue eliminada definitivamente junto con los documentos en su interior',
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