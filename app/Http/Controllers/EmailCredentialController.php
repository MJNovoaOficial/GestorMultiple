<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\EmailCredential;
use Illuminate\Http\Request;
use App\Services\AuditService;

class EmailCredentialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EmailCredential::query()
            ->where('is_active', true)
            ->with([
                'branch',
                'department',
            ]);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('full_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");

            });

        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $passwords = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('passwords.index', [
            'passwords' => $passwords,
            'branches' => Branch::all(),
            'departments' => Department::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('passwords.create', [
            'branches' => Branch::all(),
            'departments' => Department::all(),
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

        'full_name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'required|string',
        'branch_id' => 'required',
        'department_id' => 'required',

        ]);

        $existingCredential = EmailCredential
        ::where('email', $validated['email'])
        ->first();

        if ($existingCredential) {

            if ($existingCredential->is_active) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'La credencial ya existe.'
                    );

            }

            // REACTIVAR

            $existingCredential->update([

                'full_name' => $validated['full_name'],
                'password' => encrypt($validated['password']),
                'branch_id' => $validated['branch_id'],
                'department_id' => $validated['department_id'],
                'notes' => $validated['notes'] ?? null,
                'updated_by' => auth()->id(),
                'is_active' => true,

            ]);


            AuditService::log(
                'reactivated',
                $existingCredential,
                'Se agregó la credencial para ' .
                    $existingCredential->email
            );

            return redirect()
                ->route('passwords.index')
                ->with(
                    'success',
                    'Credencial agregada correctamente.'
                );
        }

        $credential = EmailCredential::create([

            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => encrypt($validated['password']),
            'branch_id' => $validated['branch_id'],
            'department_id' => $validated['department_id'],
            'notes' => $validated['notes'] ?? null,
            'created_by' => auth()->id(),
            'is_active' => true,

        ]);

        AuditService::log(
            'created',
            $credential,
            'Se creó la credencial para '
                . $credential->email
        );

        return redirect()
            ->route('passwords.index')
            ->with(
                'success',
                'Credencial creada correctamente.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailCredential $password)
    {
        return view('passwords.edit', [
            'password' => $password,
            'branches' => Branch::all(),
            'departments' => Department::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailCredential $password)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($password) {

                    $exists = EmailCredential::where('email', $value)
                        ->where('is_active', true)
                        ->where('id', '!=', $password->id)
                        ->exists();

                    if ($exists) {

                        $fail('Ya existe una credencial activa para este correo.');

                    }

                }
            ],
            'password' => 'required|string',
            'branch_id' => 'nullable|exists:branches,id',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $validated['updated_by'] = auth()->id();

        $oldValues = $password->getOriginal();

        $password->update($validated);

        AuditService::log(
            'updated',
            $password,
            'Se actualizaron las credenciales para ' . $password->email,
            $oldValues,
            $password->fresh()->toArray()
        );

        return redirect()
            ->route('passwords.index')
            ->with('success', 'Credencial actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailCredential $password)
    {
        AuditService::log(
            'deleted',
            $password,
            'Se han eliminado las credenciales para ' . $password->email
        );

        $password->update([
            'is_active' => false
        ]);

        return redirect()
            ->route('passwords.index')
            ->with('success', 'Credencial eliminada.');
    }
}
