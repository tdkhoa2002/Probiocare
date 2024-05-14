<?php

namespace Modules\Staking\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
    ];

    protected $table = 'staking__package_translations';
}
