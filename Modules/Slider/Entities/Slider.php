<?php

namespace Modules\Slider\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Slider extends Model
{
    protected $fillable = [
        'name',
        'system_name',
        'active',
    ];

    protected $casts = [
        'active' => 'bool',
    ];

    protected $table = 'slider__sliders';

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class)
            ->orderBy('position', 'asc');
    }

    /**
     * @return Collection<Slide>
     */
    public function getActiveSlidesAttribute(): Collection
    {
        return $this->slides
            ->where('active', '=', true)
            ->values();
    }
}
