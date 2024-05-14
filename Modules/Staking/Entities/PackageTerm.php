<?php

namespace Modules\Staking\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Staking\Entities\Package;

class PackageTerm extends Model
{
    use SoftDeletes,Translatable;

    protected $table = 'staking__packageterms';

    public $translatedAttributes = ['title'];
    protected $fillable = [
        'package_id',
        'day_reward',
        'total_stake',
        'type',
        'apr_reward',
        'max_total_stake',
        'title',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
