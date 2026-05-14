<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IpAddress;

class IpStatus extends Model{

    public function ipAddresses() 
    {
        return $this->hasMany(IpAddress::class);
    
    }
}

