<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;

class RadioFrequency extends Model
{
    protected $fillable = [
        'number',
        'serial',
        'mac',
        'ip',
        'area',
        'branch_id',
        'type',
        'status',
        'blocked',
        'warranty',
        'observations',
    ];
    
    protected $casts = [
        'blocked' => 'boolean',
        'warranty' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(
            Branch::class
        );
    }
}