<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    protected $fillable = [
    'branch_id',
    'department_id',
    'device_type_id',
    'ip_status_id',
    'ip_address',
    'assigned_user',
    'uses_vnc',
    'vnc_password',
    'observations',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class);
    }

    public function status()
    {
        return $this->belongsTo(IpStatus::class, 'ip_status_id');
    }
}

