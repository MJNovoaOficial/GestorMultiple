<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;
use App\Models\IpAddress;
use App\Models\EmailCredential;
use App\Models\CredentialAuditLog;
use App\Models\AuditLog;
use App\Models\EmployeePhone;
use App\Models\Notebook;
use App\Models\RadioFrequency;
use App\Models\Dvr;
use App\Models\Supply;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBranches = \App\Models\Branch::count();

        $totalIps = \App\Models\IpAddress::count();

        $assignedIps = \App\Models\IpAddress::whereNotNull('user_assigned')
            ->count();

        $availableIps = $totalIps - $assignedIps;

        $activeUsers = \App\Models\User::where('is_active', true)
            ->count();
        
        $usersWithPasswords = \App\Models\EmailCredential
            ::where('is_active', true)
            ->whereNotNull('password')
            ->count();

        $totalCellphones = EmployeePhone::count();

        $totalNotebooks = Notebook::count();

        $totalRadiofrequencies = RadioFrequency::count();

        $totalDvrs = Dvr::count();

        $totalDevices =
            $totalCellphones +
            $totalNotebooks +
            $totalRadiofrequencies +
            $totalDvrs;
        
        $lastAudit = DB::query()
            ->fromSub(function ($query) {

                $auditLogs = DB::table('audit_logs as al')
                    ->leftJoin('users as u', 'al.user_id', '=', 'u.id')
                    ->select(
                        'al.created_at',
                        'al.action',
                        'al.description',
                        'al.ip_address',
                        'u.name as user_name',
                        DB::raw("'general' as source")
                    );

                $credentialLogs = DB::table('credential_audit_logs as cal')
                    ->leftJoin('users as u', 'cal.user_id', '=', 'u.id')
                    ->select(
                        'cal.created_at',
                        'cal.action',
                        'cal.description',
                        'cal.ip_address',
                        'u.name as user_name',
                        DB::raw("'credential' as source")
                    );

                $query->fromSub($auditLogs->unionAll($credentialLogs), 'logs');

            }, 'logs')
            ->orderByDesc('created_at')
            ->first();
            
        $lowStockSupplies = Supply::where(
                'is_active',
                true
            )
            ->whereColumn(
                'quantity',
                '<=',
                'minimum_stock'
            )
            ->where('quantity', '>', 0)
            ->count();

        $outOfStockSupplies = Supply::where(
                'is_active',
                true
            )
            ->where('quantity', '<=', 0)
            ->count();

        $lastSupplyMovement = \App\Models\SupplyMovement::latest()
            ->first();
        
        return view('dashboard', compact(
            'totalBranches',
            'totalIps',
            'assignedIps',
            'availableIps',
            'activeUsers',
            'usersWithPasswords',
            'totalDevices',
            'totalCellphones',
            'totalNotebooks',
            'totalRadiofrequencies',
            'totalDvrs',
            'lastAudit',
            'lowStockSupplies',
            'outOfStockSupplies',
            'lastSupplyMovement',
        ));
    }
}
