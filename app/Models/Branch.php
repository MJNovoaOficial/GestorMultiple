<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RadioFrequency;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'city',
    ];

    protected $dateFormat = 'Y-m-d H:i:s';
    
    public function radioFrequencies()
    {
        return $this->hasMany(
            RadioFrequency::class
        );
    }
    
}

