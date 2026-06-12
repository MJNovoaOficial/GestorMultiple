<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;
use Illuminate\Support\Facades\Crypt;

class Dvr extends Model
{
    protected $fillable = [
        'nombre',
        'branch_id',
        'tipo',
        'modelo',
        'mp',
        'hdd',
        'sn',
        'ip',
        'password',
        'active',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] =
            empty($value)
                ? null
                : Crypt::encryptString($value);
    }

    public function getPasswordAttribute($value)
    {
        return empty($value)
            ? null
            : Crypt::decryptString($value);
    }
}
