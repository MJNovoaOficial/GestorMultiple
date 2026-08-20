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


    /**
     * Mostrar un documento.
     */
    public function show(Document $document)
    {
        //
    }


    /**
     * Mostrar formulario de edición.
     */
    public function edit(Document $document)
    {
        //
    }


    /**
     * Actualizar un documento.
     */
    public function update(Request $request, Document $document)
    {
        //
    }


    /**
     * Enviar documento a la papelera.
     */
    public function destroy(Request $request, Document $document)
    {
        //
    }


    /**
     * Restaurar documento.
     */
    public function restore(Request $request, $id)
    {
        //
    }


    /**
     * Desactivar definitivamente un documento.
     */
    public function permanentDelete(Request $request, $id)
    {
        //
    }
}