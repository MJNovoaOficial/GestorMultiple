<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IpAddress;
class DeviceType extends Model
{
    public function ipAddresses()
    {
        return $this->hasMany(IpAddress::class);
    }
}

