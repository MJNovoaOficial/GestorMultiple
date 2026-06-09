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
        
        $branches = Branch::orderBy('name')->get();

        $query = IpAddress::with([
            'branch',
            'department',
            'deviceType',
            'ipStatus',
        ]);

        if ($request->filled('branch_id')) {

            $query->where('branch_id', $request->branch_id);

        }

        if ($request->filled('subnet')) {

            $query->where(
                'ip_address',
                'like',
                $request->subnet . '.%'
            );

        }
        
        $subnets = IpAddress::selectRaw("
                SUBSTRING_INDEX(ip_address, '.', 3) as subnet
            ")
            ->when($request->branch_id, function ($q) use ($request) {

                $q->where('branch_id', $request->branch_id);

            })
            ->distinct()
            ->orderBy('subnet')
            ->pluck('subnet');


        $ipAddresses = $query
            ->orderByRaw('INET_ATON(ip_address)')
            ->get();


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

        $statusId = $assigned
            ? 2 // Ocupada
            : 1; // Disponible

        $ipAddress->update([
            'user_assigned' => $request->user_assigned,
            'department_id' => $request->department_id,
            'device_type_id' => $request->device_type_id,
            'ip_status_id' => $statusId,
        ]);

        AuditService::log(
            'updated',
            $ipAddress,
            'Se actualizó la IP: ' . $ipAddress->ip_address
        );

        return redirect()
            ->route('ip-addresses.index')
            ->with('success', 'IP actualizada correctamente.');
    }

    public function ping(Request $request)
    {
        try {

            $ip = $request->ip;

            if (!filter_var($ip, FILTER_VALIDATE_IP)) {

                return response()->json([
                    'success' => false,
                    'state'   => 'invalid',
                    'message' => 'IP inválida'
                ]);

            }

            $os = strtoupper(substr(PHP_OS, 0, 3));

            if ($os === 'WIN') {
                $command = "ping -n 1 " . escapeshellarg($ip);
            } else {
                $command = "ping -c 1 " . escapeshellarg($ip);
            }

            exec($command, $output, $status);

            $text = implode("\n", $output);

            // Convertir desde Windows-1252 para evitar errores UTF-8
            $text = iconv('Windows-1252', 'UTF-8//IGNORE', $text);

            /*
            * Detectar el resultado real del ping.
            * NO confiar únicamente en $status.
            */
            $state = 'timeout';

            if (
                str_contains($text, 'Host de destino inaccesible') ||
                str_contains($text, 'Destination host unreachable')
            ) {

                $state = 'unreachable';

            } elseif (
                str_contains($text, 'TTL=') ||
                str_contains($text, 'ttl=')
            ) {

                $state = 'success';

            }

            return response()->json([
                'success' => $state === 'success',
                'state'   => $state,
                'status'  => $status,
                'output'  => $text,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'state'   => 'error',
                'error'   => $e->getMessage(),
            ], 500);

        }
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
            'Se liberó la IP: ' . $ip->ip_address
        );

        return response()->json([
            'success' => true
        ]);
    }
}