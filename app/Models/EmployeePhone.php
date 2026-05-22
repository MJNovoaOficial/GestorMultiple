<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeePhone extends Model
{
    protected $fillable = [
        'phone_number',
        'first_name',
        'last_name',
        'phone_model',
        'delivery_date',
        'imei',
        'position',
        'department',
        'vendor_code',
        'company_name',
        'rut',
        'email',
        'observations',
        'status',
    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];

}
