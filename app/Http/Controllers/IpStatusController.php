<?php

namespace App\Http\Controllers;

use App\Models\IpStatus;
use Illuminate\Http\Request;

class IpStatusController extends Controller
{
    public function index()
    {
        $ipStatuses = IpStatus::latest()->get();

        return view('ip-statuses.index', compact('ipStatuses'));
    }

    public function create()
    {
        return view('ip-statuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
        ]);

        IpStatus::create([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        return redirect()
            ->route('ip-statuses.index')
            ->with('success', 'Estado de IP creado correctamente.');
    }

    public function edit(IpStatus $ipStatus)
    {

        return view('ip-statuses.edit', compact('ipStatus'));
    }

    public function update(Request $request, IpStatus $ipStatus)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
        ]);

        $ipStatus->update([
            'name' => $request->name,
            'color' => $request->color,
        ]);
        return redirect()
            ->route('ip-statuses.index')
            ->with('success', 'Estado de IP actualizado correctamente.');
    }
    
    public function destroy(IpStatus $ipStatus)
    {
        $ipStatus->delete();

        return redirect()
            ->route('ip-statuses.index')
            ->with('success', 'Estado de IP eliminado correctamente.');
    }
    
}
