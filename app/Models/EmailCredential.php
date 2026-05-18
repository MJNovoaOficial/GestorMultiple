<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCredential extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'branch_id',
        'department_id',
        'notes',
        'created_by',
        'updated_by',
        'last_password_change_at',
        'is_active',
    ];

    protected $casts = [
        'password' => 'encrypted',
        'last_password_change_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function auditLogs()
    {
        return $this->hasMany(CredentialAuditLog::class);
    }   
}
