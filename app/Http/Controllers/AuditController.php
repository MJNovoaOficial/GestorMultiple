<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Models\CredentialAuditLog;

class AuditController extends Controller
{
    public function index()
    {
        $credentialAudits = CredentialAuditLog::with([
            'user',
            'auditable'
        ])->get();

        $systemAudits = AuditLog::with([
            'user'
        ])->get();

        $audits = $credentialAudits
            ->concat($systemAudits)
            ->sortByDesc('created_at');

        return view(
            'audits.index',
            compact('audits')
        );
    }
}
