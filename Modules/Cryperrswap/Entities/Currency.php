<?php

namespace Modules\Cryperrswap\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'cryperrswap__currencies';
    protected $fillable = [
        'service_id',
        'code',
        'coin',
        'name',
        'network',
        'priority',
        'recv',
        'send',
        'tag',
        'logo',
        'color',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
