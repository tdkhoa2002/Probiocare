<?php

namespace Modules\Loyalty\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
    ];

    protected $table = 'loyalty__packages_translations';
}
