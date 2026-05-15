<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\IpStatus;
use App\Models\IpAddress;

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

        for ($ip = $start; $ip <= $end; $ip++) {

            $currentIp = long2ip($ip);

            /*
            |--------------------------------------------------------------------------
            | Evitar IPs reservadas
            |--------------------------------------------------------------------------
            */

            $lastOctet = explode('.', $currentIp)[3];

            if ($lastOctet == 0 ) {

                continue;

            }

            IpAddress::create([
                'ip_address' => $currentIp,
                'branch_id' => $request->branch_id,
                'ip_status_id' => $request->ip_status_id,
            ]);

        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Rango IP importado correctamente.');
    }


}
