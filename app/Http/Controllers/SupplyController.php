<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supply;
use App\Models\SupplyMovement;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SupplyController extends Controller
{  
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
            'updated_by' => auth()->id(),
            'last_critical_alert_at' => null,
            'last_out_alert_at' => null,
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

        $supply = Supply::where('barcode', $request->barcode)
            ->where('is_active', true)
            ->first();
            
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
        $validated = $request->validate([
            'type' => 'required|in:add,remove',

            'items' => 'required|array|min:1',

            'items.*.id' => 'required|integer|distinct',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            $movementType = $validated['type'];
            $items = collect($validated['items']);

            // Bloquear y validar todos los suministros antes de modificar stock.
            $supplies = Supply::whereIn(
                'id',
                $items->pluck('id')
            )
            ->where('is_active', true)
            ->lockForUpdate()
            ->get()
            ->keyBy('id');

            if ($supplies->count() !== $items->count()) {
                throw ValidationException::withMessages([
                    'items' => 'Uno o más suministros no existen o están inactivos.',
                ]);
            }

            // Validar el stock de todos los productos antes de realizar cambios.
            if ($movementType === 'remove') {
                foreach ($items as $item) {
                    $supply = $supplies->get($item['id']);

                    if ((int) $item['quantity'] > (int) $supply->quantity) {
                        return response()->json([
                            'success' => false,
                            'message' => "Stock insuficiente para {$supply->supply_type}. Disponible: {$supply->quantity}. Solicitado: {$item['quantity']}.",
                        ], 422);
                    }
                }
            }

            foreach ($items as $item) {
                $supply = $supplies->get($item['id']);
                $quantity = (int) $item['quantity'];
                $oldQuantity = (int) $supply->quantity;

                $newQuantity = $movementType === 'add'
                    ? $oldQuantity + $quantity
                    : $oldQuantity - $quantity;

                $supply->quantity = $newQuantity;
                $supply->updated_by = auth()->id();

                if ($movementType === 'add') {
                    $supply->last_critical_alert_at = null;
                    $supply->last_out_alert_at = null;
                }

                $supply->save();

                SupplyMovement::create([
                    'supply_id' => $supply->id,
                    'user_id' => auth()->id(),
                    'type' => $movementType,
                    'quantity' => $quantity,
                    'old_quantity' => $oldQuantity,
                    'new_quantity' => $newQuantity,
                ]);
            }

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => $movementType === 'add'
                    ? 'SCANNER_STOCK_AGREGADO'
                    : 'SCANNER_STOCK_DESCONTADO',
                'description' => sprintf(
                    'Movimiento mediante escáner (%s). Productos: %d. Unidades: %d.',
                    $movementType === 'add' ? 'ingreso' : 'retiro',
                    $items->count(),
                    $items->sum('quantity')
                ),
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Movimiento guardado correctamente.',
            ]);
        });
    }
}
