<?php

namespace Modules\Cryperrswap\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title'];
    protected $table = 'cryperrswap__service_translations';
}
