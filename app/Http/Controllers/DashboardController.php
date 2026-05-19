<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;
use App\Models\IpAddress;
use App\Models\EmailCredential;
use App\Models\CredentialAuditLog;

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

        $usersWithPasswords = \App\Models\EmailCredential::whereNotNull('password')
            ->count();

        $passwordCoverage = $activeUsers > 0
            ? round(($usersWithPasswords / $activeUsers) * 100)
            : 0;

        $lastAudit = CredentialAuditLog::latest()->first();
        
        return view('dashboard', compact(
            'totalBranches',
            'totalIps',
            'assignedIps',
            'availableIps',
            'activeUsers',
            'usersWithPasswords',
            'passwordCoverage',
            'lastAudit'
        ));
    }
}
