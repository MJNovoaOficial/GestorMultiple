<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceType;

class DeviceTypeController extends Controller
{
    public function index()
    {
        $deviceTypes = DeviceType::latest()->get();

        return view('device-types.index', compact('deviceTypes'));
    }
    
    public function create()
    {
        return view('device-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        DeviceType::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('device-types.index')
            ->with('success', 'Tipo de dispositivo creado correctamente.');
    }

    public function edit(DeviceType $deviceType)
    {

        return view('device-types.edit', compact('deviceType'));
    }

    public function update(Request $request, DeviceType $deviceType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $deviceType->update([
            'name' => $request->name,
        ]);
        return redirect()
            ->route('device-types.index')
            ->with('success', 'Tipo de dispositivo actualizado correctamente.');
    }

    public function destroy(DeviceType $deviceType)
    {
        $deviceType->delete();

        return redirect()
            ->route('device-types.index')
            ->with('success', 'Tipo de dispositivo eliminado correctamente.');
    }
    
}
