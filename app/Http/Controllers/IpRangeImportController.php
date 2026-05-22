<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\IpStatus;
use App\Models\IpAddress;
use App\Services\AuditService;

class IpRangeImportController extends Controller
{
    public function create()
    {
        $branches = Branch::orderBy('name')->get();
        $ipStatuses = IpStatus::orderBy('name')->get();

        return view('ip-ranges.create', compact(
            'branches',
            'ipStatuses'
        ));
    }

   public function store(Request $request)
    {
        $request->validate([
            'start_ip' => 'required|ip',
            'end_ip' => 'required|ip',
            'branch_id' => 'required|exists:branches,id',
            'ip_status_id' => 'required|exists:ip_statuses,id',
        ]);

        $start = ip2long($request->start_ip);
        $end = ip2long($request->end_ip);

        $duplicates = 0;
        $imported = 0;
        $lastCreatedIp = null;

        for ($ip = $start; $ip <= $end; $ip++) {

            $currentIp = long2ip($ip);

            /*
            |--------------------------------------------------------------------------
            | Evitar IPs reservadas
            |--------------------------------------------------------------------------
            */

            $lastOctet = explode('.', $currentIp)[3];

            if ($lastOctet == 0) {

                continue;

            }

            /*
            |--------------------------------------------------------------------------
            | Evitar IPs duplicadas
            |--------------------------------------------------------------------------
            */

            $exists = IpAddress::where(
                'ip_address',
                $currentIp
            )->exists();

            if ($exists) {

                $duplicates++;

                continue;

            }

            IpAddress::create([
                'ip_address' => $currentIp,
                'branch_id' => $request->branch_id,
                'ip_status_id' => $request->ip_status_id,
            ]);

            $imported++;

        }
        if ($lastCreatedIp) {

            AuditService::log(
                'imported',
                null,
                'Se importó un rango IP desde ' .
                $request->start_ip .
                ' hasta ' .
                $request->end_ip .
                '. Importadas: ' . $imported .
                ', omitidas: ' . $duplicates
            );

        }

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Importación completada. '
                . $imported .
                ' IPs importadas y '
                . $duplicates .
                ' duplicadas omitidas.'
            );
    }


}
