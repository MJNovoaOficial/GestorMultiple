<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RadioFrequency;
use App\Models\Dvr;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'city',
    ];
    
    public function radioFrequencies()
    {
        return $this->hasMany(
            RadioFrequency::class
        );

    }

    public function Dvrs()
    {
        return $this->hasMany(
            Dvr::class
        );
    }
    
}

