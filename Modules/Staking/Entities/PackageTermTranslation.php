<?php

namespace Modules\Staking\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageTermTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title'];
    protected $table = 'staking__packageterm_translations';
}
