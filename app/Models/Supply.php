<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SupplyMovement;

class Supply extends Model
{
    protected $fillable = [

        'brand',
        'printer_model',
        'supply_type',
        'quantity',
        'minimum_stock',
        'created_by',
        'updated_by',

    ];

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function updater()
    {
        return $this->belongsTo(
            User::class,
            'updated_by'
        );
    }

    public function movements()
    {
        return $this->hasMany(
            SupplyMovement::class
        );
    }
}