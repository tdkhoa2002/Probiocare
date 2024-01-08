<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class ThemeOptionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['value', 'description'];
    protected $table = 'setting__themeoption_translations';
}
