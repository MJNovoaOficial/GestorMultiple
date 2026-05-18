<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\IpAddress;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DeviceType;
use App\Models\IpStatus;
use App\Services\AuditService;

class IpAddressController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Sucursales
        |--------------------------------------------------------------------------
        */

        $branches = Branch::orderBy('name')->get();

        /*
        |--------------------------------------------------------------------------
        | Query principal
        |--------------------------------------------------------------------------
        */

        $query = IpAddress::with([
            'branch',
            'department',
            'deviceType',
            'ipStatus',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filtro sucursal
        |--------------------------------------------------------------------------
        */

        if ($request->filled('branch_id')) {

            $query->where('branch_id', $request->branch_id);

        }

        /*
        |--------------------------------------------------------------------------
        | Filtro subnet/rama
        |--------------------------------------------------------------------------
        */

        if ($request->filled('subnet')) {

            $query->where(
                'ip_address',
                'like',
                $request->subnet . '.%'
            );

        }
        
        /*
        |--------------------------------------------------------------------------
        | Obtener ramas únicas
        |--------------------------------------------------------------------------
        */

        $subnets = IpAddress::selectRaw("
                SUBSTRING_INDEX(ip_address, '.', 3) as subnet
            ")
            ->when($request->branch_id, function ($q) use ($request) {

                $q->where('branch_id', $request->branch_id);

            })
            ->distinct()
            ->orderBy('subnet')
            ->pluck('subnet');

        /*
        |--------------------------------------------------------------------------
        | Obtener IPs
        |--------------------------------------------------------------------------
        */

        $ipAddresses = $query
            ->orderByRaw('INET_ATON(ip_address)')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Catálogos edición
        |--------------------------------------------------------------------------
        */

        $departments = Department::orderBy('name')->get();

        $deviceTypes = DeviceType::orderBy('name')->get();

        $ipStatuses = IpStatus::orderBy('name')->get();

        return view('ip-addresses.index', compact(
            'ipAddresses',
            'branches',
            'subnets',
            'departments',
            'deviceTypes',
            'ipStatuses'
        ));
    }

    public function update(Request $request, IpAddress $ipAddress)
    {
        $request->validate([
            'user_assigned' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'device_type_id' => 'nullable|exists:device_types,id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Estado automático
        |--------------------------------------------------------------------------
        */

        $assigned = (
            $request->filled('user_assigned') ||
            $request->filled('department_id') ||
            $request->filled('device_type_id')
        );

        $statusName = $assigned
            ? 'Asignado'
            : 'Disponible';

        $status = IpStatus::where('name', $statusName)->first();

        $ipAddress->update([
            'user_assigned' => $request->user_assigned,
            'department_id' => $request->department_id,
            'device_type_id' => $request->device_type_id,
            'ip_status_id' => $status->id,
        ]);
        AuditService::log(
            'updated',
            $ip,
            'IP actualizada: ' . $ip->ip_address
        );

        return redirect()
            ->route('ip-addresses.index')
            ->with('success', 'IP actualizada correctamente.');
    }

    public function ping(Request $request)
    {
        $ip = $request->ip;

        $os = strtoupper(substr(PHP_OS, 0, 3));

        if ($os === 'WIN') {
            $command = "ping -n 1 $ip";
        } else {
            $command = "ping -c 1 $ip";
        }

        exec($command, $output, $status);

        return response()->json([
            'success' => $status === 0
        ]);
    }

    public function release(IpAddress $ip)
    {
        $availableStatus = IpStatus::where('name', 'Disponible')->first();

        $ip->update([

            'user_assigned' => null,
            'device_type_id' => null,
            'department_id' => null,

            'ip_status_id' => $availableStatus->id

        ]);

        AuditService::log(
            'released',
            $ip,
            'IP liberada: ' . $ip->ip_address
        );

        return response()->json([
            'success' => true
        ]);
    }
}