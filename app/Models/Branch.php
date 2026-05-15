<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IpAddress;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'city',
    ];
    public function ipAddresses()
    {
        return $this->hasMany(IpAddress::class);
    }
}

