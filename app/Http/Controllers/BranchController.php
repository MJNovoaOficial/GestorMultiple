<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;


class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->get();
        return view('branches.index', compact('branches'));
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Branch::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('branches.index')
            ->with('success', 'Sucursal creada correctamente.');
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
    public function edit(Branch $branch)
    {

        return view('branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $branch->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('branches.index')
            ->with('success', 'Sucursal actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()
            ->route('branches.index')
            ->with('success', 'Sucursal eliminada correctamente.');
    }
}
