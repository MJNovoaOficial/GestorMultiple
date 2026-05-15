<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    protected $fillable = [
        'ip_address',
        'branch_id',
        'department_id',
        'device_type_id',
        'ip_status_id',
        'hostname',
        'mac_address',
        'description',
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

    public function ipStatus()
    {
        return $this->belongsTo(IpStatus::class);
    }
}

