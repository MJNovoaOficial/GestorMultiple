<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CredentialAuditLog;

class AuditController extends Controller
{
    public function index()
    {
        $audits = CredentialAuditLog::with([
            'user',
            'emailCredential'
        ])
        ->latest()
        ->paginate(50);

        return view('audits.index', compact('audits'));
    }
}
