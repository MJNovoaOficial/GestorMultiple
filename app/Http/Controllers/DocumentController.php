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
    public function index(Request $request, DocumentCategory $category)
    {
        $search = $request->input('search');

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
            compact('category', 'documents', 'search')
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
        //validamos los datos antes de guardar
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

                //recogemos los datos del nombre y descripción
                $name = $request->input(
                    "names.$index"
                );
                $description = $request->input(
                    "descriptions.$index"
                );
                //ubicación de donde ser guardará la imagen subida por el usuario
                $path = $file->store(
                    'documentacion/' . $category->id,
                    'public'
                );

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
                //Auditoría al subir el archivo
                AuditLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'created',
                    'description' => 'Se ha subido el documento "' . $document->name . '"',
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