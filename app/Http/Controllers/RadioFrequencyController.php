<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\RadioFrequency;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\AuditLog;

class RadioFrequencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            ->latest()
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::orderBy('name')->get();

        return view(
            'radio-frequencies.create',
            compact('branches')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'number' => [
                'required',
                'numeric',
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

    /**
     * Display the specified resource.
     */
    public function show(RadioFrequency $radioFrequency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RadioFrequency $radioFrequency)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,RadioFrequency $radioFrequency)
    {
        $validated = $request->validate([

            'number' => [
                'required',
                'numeric',

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RadioFrequency $radioFrequency)
    {
        //
    }
}
