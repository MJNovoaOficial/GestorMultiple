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

            'auditable_type' => $model::class,

            'auditable_id' => $model->id,

            'user_id' => auth()->id(),

            'action' => $action,

            'description' => $description,

            'old_values' => $oldValues
                ? json_encode($oldValues)
                : null,

            'new_values' => $newValues
                ? json_encode($newValues)
                : null,

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

        ]);
    }
}