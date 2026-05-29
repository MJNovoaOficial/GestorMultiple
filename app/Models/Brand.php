<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [

        'name',

    ];

    public function notebooks()
    {
        return $this->hasMany(Notebook::class);
    }
}