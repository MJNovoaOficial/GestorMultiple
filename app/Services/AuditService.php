<?php

namespace App\Services;

use App\Models\CredentialAuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditService
{
    public static function log(
        string $action,
        Model $model,
        ?string $description = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): void {

        CredentialAuditLog::create([
            'email_credential_id' => $model->id,

            'user_id' => auth()->id(),

            'action' => $action,

            'description' => $description,

            'old_values' => $oldValues,

            'new_values' => $newValues,

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),
        ]);
    }
}