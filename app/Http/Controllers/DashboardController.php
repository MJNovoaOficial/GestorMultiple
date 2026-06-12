<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;
use App\Models\IpAddress;
use App\Models\EmailCredential;
use App\Models\CredentialAuditLog;
use App\Models\EmployeePhone;
use App\Models\Notebook;
use App\Models\RadioFrequency;
use App\Models\Dvr;
use App\Models\Supply;

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
        
        $lastAudit = CredentialAuditLog::latest()->first();
       
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
