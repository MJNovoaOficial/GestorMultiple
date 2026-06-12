<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Dvr;
use Illuminate\Http\Request;
use App\Models\AuditLog;

class DvrController extends Controller
{
    
    public function index(Request $request)
    {  
        $branches = Branch::withCount([
        
        'dvrs' => function ($query) {
                $query->where('active', true);
        }])
            ->orderBy('name')
            ->get();

        $query = Dvr::with('branch')
            ->where('active', true);

        // Filtro sucursal
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        // Buscador
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('modelo', 'like', "%{$search}%")
                    ->orWhere('sn', 'like', "%{$search}%")
                    ->orWhere('ip', 'like', "%{$search}%")
                    ->orWhere('tipo', 'like', "%{$search}%");
            });
        }

        $dvrs = $query
            ->orderBy('nombre')
            ->paginate(25)
            ->withQueryString();

        $totalDvrs = Dvr::where('active', true)->count();

        return view('dvrs.index', compact(
            'dvrs',
            'branches',
            'totalDvrs'
        ));

    }

    public function create()
    {
        $branches = Branch::orderBy('name')->get();

        return view(
            'dvrs.create',
            compact('branches')
        );
    }

    public function store(Request $request)
    {
        $validated = $request ->validate([

            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'branch_id' => [
                'required',
                'exists:branches,id',
            ],

            'tipo' => [
                'required',
                'in:DVR,NVR,IPC',
            ],

            'modelo' => [
                'required',
                'string',
                'max:255',
            ],

            'mp' => [
                'required',
                'in:1MP,2MP,4MP,5MP,8MP',
            ],

            'hdd' => [
                'required',
                'in:128GB,256GB,500GB,1TB,2TB,4TB,6TB,8TB',
            ],

            'sn' => [
                'required',
                'string',
                'max:255',
            ],

            'ip' => [
                'required',
                'string',
                'max:255',
            ],

            'password' => [
                'required',
                'string',
            ],
        ],[
            '*.required' => 'Este campo es obligatorio.',
        ]);

        // Crear DVR
        $dvr = Dvr::create($validated);

        // Auditoría
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'description' =>
                'Creó el DVR '
                . $dvr->nombre,
            'ip_address'=> $request->ip(),
        ]);

        return redirect()
            ->route('dvrs.index')
            ->with(
                'success',
                'Registro creado correctamente.'
            );

    }

    public function password(Dvr $dvr)
    {
        return response()->json([
            'password' => $dvr->password,
        ]);
    }

    public function retire(Dvr $dvr)
    {
        $dvr->update([
            'active' => false,
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'description' =>
                'Eliminó el DVR '
                . $dvr->nombre,
            'ip_address' => request()->ip(),
        ]);

        return back()->with(
            'success',
            'DVR dado de baja correctamente.'
        );
    }
    
    public function update(Request $request, Dvr $dvr)
    {
        $validated = $request->validate([
            
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'branch_id' => [
                'required',
                'exists:branches,id',
            ],

            'tipo' => [
                'required',
                'in:DVR,NVR,IPC',
            ],

            'modelo' => [
                'required',
                'string',
                'max:255',
            ],

            'mp' => [
                'required',
                'in:1MP,2MP,4MP,5MP,8MP',
            ],

            'hdd' => [
                'required',
                'in:128GB,256GB,500GB,1TB,2TB,4TB,6TB,8TB',
            ],

            'sn' => [
                'required',
                'string',
                'max:255',
            ],

            'ip' => [
                'required',
                'string',
                'max:255',
            ],

            'password' => [
                'required',
                'string',
            ],
        ],[
            '*.required' => 'Este campo es obligatorio.',
        ]);

        $dvr->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),

            'action' => 'update',

            'description' =>
                'Actualizó el DVR de '
                . $dvr->nombre,

            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->route('dvrs.index')
            ->with(
                'success',
                'Registro actualizado correctamente.'
            );
    }

}
