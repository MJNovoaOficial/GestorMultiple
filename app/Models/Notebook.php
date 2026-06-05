<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;

class Notebook extends Model
{
    protected $fillable = [
        'user_name',
        'user_rut',
        'serial_number',
        'model',
        'brand_id',
        'delivery_date',
        'purchase_value',
        'condition',
        'status',
        'position',
        'company_name',
        'observations',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}