<?php

namespace Modules\Loyalty\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use Translatable;

    protected $table = 'loyalty__packages';
    public $translatedAttributes = [];
    protected $fillable = [
        'name',
        'reward',
        'cashback',
        'day_reward',
        'term_matching',
        'status'
    ];
}
