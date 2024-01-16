<?php

namespace Modules\Loyalty\Events;

use Modules\Media\Contracts\StoringMedia;
use Modules\Loyalty\Entities\Package;

class PackageWasUpdated implements StoringMedia
{
    public $data;
    public $package;

    public function __construct(Package $package, array $data)
    {
        $this->data = $data;
        $this->package = $package;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->package;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
