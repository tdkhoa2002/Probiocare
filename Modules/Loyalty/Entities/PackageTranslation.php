<?php

namespace Modules\Loyalty\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'loyalty__package_translations';
}
