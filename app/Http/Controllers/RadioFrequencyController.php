<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\RadioFrequency;
use App\Exports\RadioFrequencyExport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AuditLog;

class RadioFrequencyController extends Controller
{
    
    public function index(Request $request)
    {
        $query = RadioFrequency::query();

        if ($request->filled('search')) {
            $terms = explode(' ', $request->search);
            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->where('number', 'like', "%{$term}%")
                            ->orWhere('serial', 'like', "%{$term}%")
                            ->orWhere('mac', 'like', "%{$term}%")
                            ->orWhere('ip', 'like', "%{$term}%")
                            ->orWhere('type', 'like', "%{$term}%");
                    });
                }
            });
        }

        if ($request->filled('branch')) {

            $query->where(
                'branch_id',
                $request->branch
            );

        }
        if ($request->filled('area')) {

            $query->where(
                'area',
                $request->area
            );

        }

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        $radioFrequencies = $query
            ->with('branch')
            ->orderByRaw('CAST(number AS INT) ASC')
            ->paginate(25)
            ->withQueryString();

        $branches = Branch::withCount('radioFrequencies')
            ->orderBy('name')
            ->get();

        $totalRadioFrequencies = RadioFrequency::count();

        $areas = RadioFrequency::select('area')
            ->whereNotNull('area')
            ->distinct()
            ->orderBy('area')
            ->pluck('area');

        return view(
            'radio-frequencies.index',
            compact(
                'radioFrequencies',
                'branches',
                'totalRadioFrequencies',
                'areas'
            )
        );
    }

    public function create()
    {
        $branches = Branch::orderBy('name')->get();

        return view(
            'radio-frequencies.create',
            compact('branches')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'number' => [
                'required',
                'string',
                'max:255',
                'unique:radio_frequencies,number',
            ],

            'serial' => [
                'required',
                'string',
                'max:255',
            ],

            'mac' => [
                'required',
                'string',
                'max:255',
            ],

            'ip' => [
                'required',
                'string',
                'max:255',
            ],

            'area' => [
                'required',
                'string',
                'max:255',
            ],

            'branch_id' => [
                'required',
                'exists:branches,id',
            ],

            'type' => [
                'required',
                'in:windows,android,cellphone',
            ],

            'status' => [
                'required',
                'in:operative,repair,retired',
            ],

            'blocked' => [
                'required',
                'boolean',
            ],

            'warranty' => [
                'required',
                'boolean',
            ],

            'observations' => [
                'nullable',
                'string',
            ],

        ], [

            '*.required' => 'Este campo es obligatorio.',

        ]);

        // Crear Radiofrecuencia
        $radioFrequency = RadioFrequency::create($validated);

        // Auditoría
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'description' =>
                'Creó radiofrecuencia N° '
                . $radioFrequency->number,
            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->route('radio-frequencies.index')
            ->with(
                'success',
                'Registro creado correctamente.'
            );
    }

    public function update(Request $request,RadioFrequency $radioFrequency)
    {
        $validated = $request->validate([

            'number' => [
                'required',
                'string',

                Rule::unique(
                    'radio_frequencies',
                    'number'
                )->ignore($radioFrequency->id),
            ],

            'serial' => [
                'required',
                'string',
                'max:255',
            ],

            'mac' => [
                'required',
                'string',
                'max:255',
            ],

            'ip' => [
                'required',
                'string',
                'max:255',
            ],

            'area' => [
                'required',
                'string',
                'max:255',
            ],

            'branch_id' => [
                'required',
                'exists:branches,id',
            ],

            'type' => [
                'required',
                'in:windows,android,cellphone',
            ],

            'status' => [
                'required',
                'in:operative,repair,retired',
            ],

            'blocked' => [
                'required',
                'boolean',
            ],

            'warranty' => [
                'required',
                'boolean',
            ],

            'observations' => [
                'nullable',
                'string',
            ],

        ], [

            '*.required' => 'Este campo es obligatorio.',

        ]);

        $radioFrequency->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),

            'action' => 'update',

            'description' =>
                'Actualizó radiofrecuencia N° '
                . $radioFrequency->number,

            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->route('radio-frequencies.index')
            ->with(
                'success',
                'Registro actualizado correctamente.'
            );
    }

    public function export(Request $request)
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'export',
            'description' => 'Exportó Radiofrecuencias a Excel.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return Excel::download(
            new RadioFrequencyExport(),
            'radiofrecuencias-' . now()->format('Y-m-d-His') . '.xlsx'
        );
    }

}
