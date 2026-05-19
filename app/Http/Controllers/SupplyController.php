<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supply;
use App\Models\SupplyMovement;
use App\Models\AuditLog;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $query = Supply::where(
            'is_active',
            true
        );

        if ($request->filter === 'critical') {

            $query->whereColumn(
                'quantity',
                '<=',
                'minimum_stock'
            )
            ->where('quantity', '>', 0);

        }

        if ($request->filter === 'out') {

            $query->where(
                'quantity',
                '<=',
                0
            );

        }

        $supplies = $query
            ->latest()
            ->paginate(20);

        return view(
            'supplies.index',
            compact('supplies')
        );
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'brand' => 'required|string|max:255',

            'printer_model' => 'required|string|max:255',

            'supply_type' => 'required|string|max:255',

            'quantity' => 'required|integer|min:0',

            'minimum_stock' => 'required|integer|min:0',

        ]);

        $validated['created_by'] = auth()->id();

        $validated['updated_by'] = auth()->id();

        Supply::create($validated);

        return redirect()
            ->route('supplies.index')
            ->with(
                'success',
                'Suministro registrado correctamente.'
            );
    }

    public function addStock(Request $request, Supply $supply)
    {
        $request->validate([

            'quantity' => 'required|integer|min:1',

        ]);

        $oldQuantity = $supply->quantity;

        $supply->increment(
            'quantity',
            $request->quantity
        );

        $supply->update([
            'updated_by' => auth()->id()
        ]);

        SupplyMovement::create([

            'supply_id' => $supply->id,

            'user_id' => auth()->id(),

            'type' => 'add',

            'quantity' => $request->quantity,

            'old_quantity' => $oldQuantity,

            'new_quantity' => $supply->fresh()->quantity,

        ]);
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'STOCK_AGREGADO',

            'description' =>
                'Se agregaron ' .
                $request->quantity .
                ' unidades a ' .
                $supply->supply_type,

            'ip_address' => request()->ip(),
        ]);

        return back()->with(
            'success',
            'Stock agregado correctamente.'
        );
    }

    public function removeStock(Request $request, Supply $supply)
    {
        $request->validate([

            'quantity' => 'required|integer|min:1',

        ]);

        if ($request->quantity > $supply->quantity) {

            return back()->with(
                'error',
                'No puedes descontar más stock del disponible.'
            );

        }

        $oldQuantity = $supply->quantity;

        $supply->decrement(
            'quantity',
            $request->quantity
        );

        $supply->update([
            'updated_by' => auth()->id()
        ]);

        SupplyMovement::create([

            'supply_id' => $supply->id,

            'user_id' => auth()->id(),

            'type' => 'remove',

            'quantity' => $request->quantity,

            'old_quantity' => $oldQuantity,

            'new_quantity' => $supply->fresh()->quantity,

        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'STOCK_DESCONTADO',

            'description' =>
                'Se descontaron ' .
                $request->quantity .
                ' unidades de ' .
                $supply->supply_type,

            'ip_address' => request()->ip(),
        ]);

        return back()->with(
            'success',
            'Stock descontado correctamente.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Supply $supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supply $supply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supply $supply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supply $supply)
    {
        SupplyMovement::create([

            'supply_id' => $supply->id,

            'user_id' => auth()->id(),

            'type' => 'delete',

            'quantity' => 0,

            'old_quantity' => $supply->quantity,

            'new_quantity' => 0,

        ]);

        $supply->update([

            'is_active' => false,

            'updated_by' => auth()->id(),

        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'SUMINISTRO_DESACTIVADO',

            'description' =>
                'Se desactivó el suministro ' .
                $supply->supply_type,

            'ip_address' => request()->ip(),
        ]);
        return back()->with(
            'success',
            'Suministro eliminado correctamente.'
        );
    }
}
