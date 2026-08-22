<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Mostrar los documentos de una categoría.
     */
    public function index(DocumentCategory $category)
    {
        $documents = $category->documents()
            ->where('is_active', true)
            ->latest()
            ->get();

        return view(
            'documentacion.category',
            compact('category', 'documents')
        );
    }


    /**
     * Mostrar formulario para subir un documento.
     */
    public function create(DocumentCategory $category)
    {
        return view(
            'documentacion.partials.document-upload-modal',
            compact('category')
        );
    }


    /**
     * Guardar un nuevo documento.
     */
    public function store(Request $request, DocumentCategory $category)
    {
        $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|max:51200',

            'names' => 'required|array|min:1',
            'names.*' => 'required|string|max:255',

            'descriptions' => 'nullable|array',
            'descriptions.*' => 'nullable|string',
        ]);


        DB::beginTransaction();

        try {

            foreach ($request->file('files') as $index => $file) {

                /*
                |--------------------------------------------------------------------------
                | Nombre y descripción
                |--------------------------------------------------------------------------
                */

                $name = $request->input(
                    "names.$index"
                );

                $description = $request->input(
                    "descriptions.$index"
                );


                /*
                |--------------------------------------------------------------------------
                | Guardar archivo
                |--------------------------------------------------------------------------
                */

                $path = $file->store(
                    'documentacion/' . $category->id,
                    'public'
                );


                /*
                |--------------------------------------------------------------------------
                | Crear documento
                |--------------------------------------------------------------------------
                */

                $document = Document::create([

                    'category_id' => $category->id,

                    'name' => $name,

                    'description' => $description,

                    'file_path' => $path,

                    'file_name' => $file->getClientOriginalName(),

                    'file_type' => $file->getClientOriginalExtension(),

                    'file_size' => $file->getSize(),

                    'created_by' => auth()->id(),

                ]);


                /*
                |--------------------------------------------------------------------------
                | Auditoría
                |--------------------------------------------------------------------------
                */

                // Aquí colocaremos el AuditLog cuando conectemos
                // exactamente el mismo sistema que usamos para categorías.

            }


            DB::commit();


            return redirect()
                ->route(
                    'documentacion.category',
                    $category
                )
                ->with(
                    'success',
                    'Los documentos fueron subidos correctamente.'
                );


        } catch (\Throwable $e) {

            DB::rollBack();


            return back()
                ->withInput()
                ->with(
                    'error',
                    'No fue posible subir los documentos.'
                );

        }
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
        $categories = DocumentCategory::onlyTrashed()
            ->withCount([
                'documents' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->latest('deleted_at')
            ->get();


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

    /**
     * Actualizar un documento.
     */
    public function update(Request $request, Document $document)
    {
        if (!$document->is_active) {
            abort(404);
        }
        /*
        |--------------------------------------------------------------------------
        | VALIDACIÓN
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        /*
        |--------------------------------------------------------------------------
        | GUARDAR VALORES ANTERIORES
        |--------------------------------------------------------------------------
        */
        $oldValues = [
            'id' => $document->id,
            'name' => $document->name,
            'description' => $document->description,
        ];
        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR
        |--------------------------------------------------------------------------
        */
        $document->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);
        /*
        |--------------------------------------------------------------------------
        | AUDITORÍA
        |--------------------------------------------------------------------------
        */
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'description' =>
                'Documento "' .
                $document->name .
                '" actualizado',
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
    /**
     * Enviar documento a la papelera.
     */
    public function destroy(Request $request, Document $document)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDAR QUE EL DOCUMENTO ESTÉ ACTIVO
        |--------------------------------------------------------------------------
        */

        if (!$document->is_active) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | GUARDAR VALORES ANTERIORES
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | ELIMINACIÓN INDIVIDUAL
        |--------------------------------------------------------------------------
        */

        $document->deleted_with_category = false;
        $document->save();

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
                'Documento "' .
                $document->name .
                '" enviado a la papelera',

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
    

        /*
        |--------------------------------------------------------------------------
        | REDIRECCIÓN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'documentacion.category',
                $document->category_id
            )
            ->with(
                'success',
                'El documento fue enviado a la papelera.'
            );
    }
    
    /**
     * Restaurar documento.
     */
    public function restore(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | BUSCAR DOCUMENTO ELIMINADO
        |--------------------------------------------------------------------------
        */
        $document = Document::withTrashed()
            ->findOrFail($id);
        /*
        |--------------------------------------------------------------------------
        | VALIDAR QUE ESTÉ EN LA PAPELERA
        |--------------------------------------------------------------------------
        */
        if (!$document->deleted_at) {
            abort(404);
        }
        /*
        |--------------------------------------------------------------------------
        | GUARDAR VALORES ANTERIORES
        |--------------------------------------------------------------------------
        */
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
        /*
        |--------------------------------------------------------------------------
        | RESTAURAR DOCUMENTO
        |--------------------------------------------------------------------------
        */
        $document->restore();
        $document->is_active = true;
        $document->deleted_with_category = false;
        $document->save();
        /*
        |--------------------------------------------------------------------------
        | AUDITORÍA
        |--------------------------------------------------------------------------
        */
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
        /*
        |--------------------------------------------------------------------------
        | REDIRECCIÓN
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('documentacion.trash')
            ->with(
                'success',
                'El documento fue restaurado correctamente.'
            );
    }


    /**
     * Desactivar definitivamente un documento.
     */
    public function permanentDelete(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | BUSCAR DOCUMENTO ELIMINADO
        |--------------------------------------------------------------------------
        */
        $document = Document::withTrashed()
            ->findOrFail($id);
        /*
        |--------------------------------------------------------------------------
        | VALIDAR QUE ESTÉ EN LA PAPELERA
        |--------------------------------------------------------------------------
        */
        if (!$document->deleted_at) {
            abort(404);
        }
        /*
        |--------------------------------------------------------------------------
        | GUARDAR VALORES ANTERIORES
        |--------------------------------------------------------------------------
        */
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
        /*
        |--------------------------------------------------------------------------
        | ELIMINAR ARCHIVO FÍSICO
        |--------------------------------------------------------------------------
        */
        if (
            $document->file_path &&
            Storage::disk('public')->exists($document->file_path)
        ) {

            Storage::disk('public')->delete(
                $document->file_path
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DESACTIVAR DEFINITIVAMENTE
        |--------------------------------------------------------------------------
        */
        $document->is_active = false;
        $document->save();
        /*
        |--------------------------------------------------------------------------
        | AUDITORÍA
        |--------------------------------------------------------------------------
        */
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
        /*
        |--------------------------------------------------------------------------
        | REDIRECCIÓN
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('documentacion.trash')
            ->with(
                'success',
                'El documento fue eliminado definitivamente.'
            );
    }
}