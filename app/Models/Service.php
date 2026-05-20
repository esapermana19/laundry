<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'service_code',
        'service_name',
        'unit',
        'delivery_type',
        'price_per_unit'
    ];
}
