<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = [

        'brand',
        'printer_model',
        'supply_type',
        'quantity',
        'minimum_stock',
        'notes',
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
}