<?php

namespace Modules\Loyalty\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageTermTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title'];
    protected $table = 'loyalty__packageterm_translations';
}
