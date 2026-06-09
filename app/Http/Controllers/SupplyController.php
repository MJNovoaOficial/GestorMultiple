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
    
    public function create()
    {
        return view('supplies.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([

            'brand' => 'required|string|max:255',

            'printer_model' => 'required|string|max:255',

            'supply_type' => 'required|string|max:255',

            'quantity' => 'required|integer|min:0',

            'minimum_stock' => 'required|integer|min:0',

            'barcode' => 'nullable|string|max:100|unique:supplies,barcode',

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

    public function scanner()
    {
        return view('supplies.scanner');
    }

    public function findByBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required'
        ]);

        $supply = Supply::where(
            'barcode',
            $request->barcode
        )->first();

        if (!$supply) {

            return response()->json([
                'success' => false,
                'message' => 'Suministro no encontrado.'
            ]);

        }

        return response()->json([
            'success' => true,
            'supply' => $supply
        ]);
    }

    public function processScannerMovement(Request $request)
    {
        $request->validate([
            'type' => 'required|in:add,remove',
            'items' => 'required|array|min:1',
        ]);

        foreach ($request->items as $item) {

            $supply = Supply::find($item['id']);

            if (!$supply) {
                continue;
            }

            $quantity = (int) $item['quantity'];

            $oldQuantity = $supply->quantity;

            if ($request->type === 'add') {

                $supply->increment(
                    'quantity',
                    $quantity
                );

            } else {

                if ($quantity > $supply->quantity) {

                    return response()->json([
                        'success' => false,
                        'message' =>
                            "No hay suficiente stock para {$supply->supply_type}"
                    ], 422);

                }

                $supply->decrement(
                    'quantity',
                    $quantity
                );
            }

            $newQuantity = $supply->fresh()->quantity;

            SupplyMovement::create([

                'supply_id' => $supply->id,

                'user_id' => auth()->id(),

                'type' => $request->type,

                'quantity' => $quantity,

                'old_quantity' => $oldQuantity,

                'new_quantity' => $newQuantity,

            ]);
        }

        AuditLog::create([

            'user_id' => auth()->id(),

            'action' =>
                $request->type === 'add'
                    ? 'SCANNER_STOCK_AGREGADO'
                    : 'SCANNER_STOCK_DESCONTADO',

            'description' =>
                'Movimiento realizado mediante escáner',

            'ip_address' => request()->ip(),

        ]);

        return response()->json([
            'success' => true
        ]);
    }
}
