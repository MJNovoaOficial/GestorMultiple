<?php

namespace App\Http\Controllers;

use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Storage;


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
        $categories = DocumentCategory::onlyTrashed()
            ->where('is_active', true)
            ->withCount('documents')
            ->orderByDesc('deleted_at')
            ->get();

        return view('documentacion.trash', compact('categories'));
    }

    public function destroy(Request $request, DocumentCategory $documentacion)
    {
        // Guardamos los datos antes del Soft Delete
        $oldValues = [
            'id' => $documentacion->id,
            'name' => $documentacion->name,
            'description' => $documentacion->description,
            'image' => $documentacion->image,
            'created_by' => $documentacion->created_by,
        ];

        // Soft Delete
        $documentacion->delete();

        // Registrar auditoría
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'description' => 'Categoría de carpeta "' . $documentacion->name . '" enviada a la papelera',

            'old_values' => $oldValues,

            'new_values' => [
                'deleted_at' => $documentacion->deleted_at,
            ],

            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('documentacion.index')
            ->with(
                'success',
                'La categoría fue enviada a la papelera.'
            );
    }

    public function restore(Request $request, $id)
    {
        $documentacion = DocumentCategory::withTrashed()
            ->findOrFail($id);

        // Guardamos los datos antes de restaurar
        $oldValues = [
            'id' => $documentacion->id,
            'name' => $documentacion->name,
            'description' => $documentacion->description,
            'image' => $documentacion->image,
            'created_by' => $documentacion->created_by,
            'deleted_at' => $documentacion->deleted_at,
        ];

        // Restaurar categoría
        $documentacion->restore();

        // Registrar auditoría
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'reactivated',
            'description' => 'Categoría de carpeta "' . $documentacion->name . '" restaurada',

            'old_values' => $oldValues,

            'new_values' => [
                'id' => $documentacion->id,
                'name' => $documentacion->name,
                'description' => $documentacion->description,
                'image' => $documentacion->image,
                'created_by' => $documentacion->created_by,
                'deleted_at' => null,
            ],

            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('documentacion.index')
            ->with(
                'success',
                'La categoría fue restaurada correctamente.'
            );
    }

    public function permanentDelete(Request $request, $id)
    {
        $documentacion = DocumentCategory::withTrashed()
            ->findOrFail($id);

        // Guardamos los datos antes de desactivar
        $oldValues = [
            'id' => $documentacion->id,
            'name' => $documentacion->name,
            'description' => $documentacion->description,
            'image' => $documentacion->image,
            'created_by' => $documentacion->created_by,
            'deleted_at' => $documentacion->deleted_at,
            'is_active' => $documentacion->is_active,
        ];

        // Desactivación definitiva para la aplicación
        $documentacion->is_active = false;
        $documentacion->save();

        // Registrar auditoría
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_permanently',
            'description' => 'Categoría de carpeta "' . $documentacion->name . '" eliminada definitivamente',

            'old_values' => $oldValues,

            'new_values' => [
                'id' => $documentacion->id,
                'name' => $documentacion->name,
                'is_active' => false,
            ],

            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('documentacion.trash')
            ->with(
                'success',
                'La categoría fue eliminada definitivamente.'
            );
    }

}