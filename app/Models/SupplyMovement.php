<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyMovement extends Model
{
    protected $fillable = [

        'supply_id',
        'user_id',
        'type',
        'quantity',
        'old_quantity',
        'new_quantity'
    ];

    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}