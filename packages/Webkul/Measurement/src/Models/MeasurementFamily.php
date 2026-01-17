<?php

namespace Webkul\Measurement\Models;

use Illuminate\Database\Eloquent\Model;

class MeasurementFamily extends Model
{
    protected $fillable = [
        'code',
        'name',
        'labels',
        'standard_unit',
        'units',
        'symbol',
    ];

    protected $casts = [
        'labels' => 'array',
        'units'  => 'array',
    ];
}
